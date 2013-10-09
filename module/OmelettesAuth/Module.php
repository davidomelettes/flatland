<?php

namespace OmelettesAuth;

use OmelettesAuth\Form\ForgotPasswordFilter,
	OmelettesAuth\Form\LoginFilter,
	OmelettesAuth\Form\ResetPasswordFilter,
	OmelettesAuth\Storage\Session as StorageSession,
	OmelettesAuth\Model\User,
	OmelettesAuth\Model\UserLoginsMapper,
	OmelettesAuth\Model\UsersMapper;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter,
	Zend\Authentication\AuthenticationService,
	Zend\Db\ResultSet\ResultSet,
	Zend\Db\TableGateway\TableGateway,
	Zend\Http\Header\SetCookie,
	Zend\Mvc\MvcEvent,
	Zend\Permissions\Acl;

class Module
{
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
	
	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'AclService' => function($sm) {
					$acl = new Acl\Acl();
					$config = $sm->get('config');
					if (is_array($config) && isset($config['acl'])) {
						$config = $config['acl'];
						if (is_array($config) && isset($config['roles'])) {
							$roles = $config['roles'];
							foreach ($roles as $role => $roleParents) {
								$role = new Acl\Role\GenericRole($role);
								$acl->addRole($role, $roleParents);
							}
						}
						if (is_array($config) && isset($config['resources'])) {
							$resources = $config['resources'];
							foreach ($resources as $role => $roleResources) {
								foreach ($roleResources as $resource) {
									if (!$acl->hasResource($resource)) {
										$acl->addResource(new Acl\Resource\GenericResource($resource));
									}
									$acl->allow($role, $resource);
								}
							}
						}
					}
				
					return $acl;
				},
				'AuthService' => function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$dbTableAuthAdapter = new DbTableAuthAdapter(
							$dbAdapter,
							'users',
							'name',
							'password_hash',
							"sha256(?||salt) AND acl_role = 'user'"
					);
				
					$authService = new AuthenticationService();
					$authService->setAdapter($dbTableAuthAdapter);
					$authService->setStorage($sm->get('OmelettesAuth\Storage\Session'));
				
					return $authService;
				},
				'OmelettesAuth\Form\ForgotPasswordFilter' => function($sm) {
					$filter = new ForgotPasswordFilter($sm->get('OmelettesAuth\Model\UsersMapper'));
					return $filter;
				},
				'OmelettesAuth\Form\LoginFilter' => function($sm) {
					$filter = new LoginFilter();
					return $filter;
				},
				'OmelettesAuth\Model\UserLoginsMapper' => function($sm) {
					$gateway = $sm->get('UserLoginsTableGateway');
					$mapper = new UserLoginsMapper($gateway);
					return $mapper;
				},
				'OmelettesAuth\Model\UsersMapper' => function($sm) {
					$gateway = $sm->get('UsersTableGateway');
					$mapper = new UsersMapper($gateway);
					return $mapper;
				},
				'OmelettesAuth\Storage\Session' => function($sm) {
					$gateway = $sm->get('UserLoginsTableGateway');
					return new StorageSession(StorageSession::STORAGE_NAMESPACE);
				},
				'UserLoginsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					return new TableGateway('user_logins', $dbAdapter, null, $resultSetPrototype);
				},
				'UsersTableGateway' => function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new User());
					return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
				},
			),
		);
	}
	
	public function onBootstrap(MvcEvent $e)
	{
		$em = $e->getApplication()->getEventManager();
		$em->attach('route', array($this, 'checkAuth'));
		$em->attach('route', array($this, 'checkAcl'));
	}
	
	/**
	 * Ensures that the auth identity is kept fresh
	 * Handles cookie-based authentication
	 * 
	 * @param MvcEvent $e
	 */
	public function checkAuth(MvcEvent $e)
	{
		$app = $e->getApplication();
		$sm = $app->getServiceManager();
		$auth = $sm->get('AuthService');
		
		if ($auth->hasIdentity()) {
			// User is logged in, session is fresh
			$authMapper = $sm->get('OmelettesAuth\Model\UsersMapper');
			$currentIdentity = $auth->getIdentity();
			if (false === ($freshIdentity = $authMapper->find($currentIdentity->key))) {
				// Can't find the user for some reason
				$auth->getStorage()->forgetMe();
				$auth->clearIdentity();
				return $this->redirectToRoute($e, 'login');
			}
			// Refresh the identity
			$auth->getStorage()->write($freshIdentity);
		} else {
			// Perhaps the session has expired
			// Can we authenticate via a login cookie?
			$request = $e->getRequest();
			$cookie = $request->getCookie();
			if ($cookie->offsetExists('login')) {
				// Attempt a cookie-based authentication
				$userLoginsMapper = $sm->get('OmelettesAuth\Model\UserLoginsMapper');
				if (FALSE !== ($cookieData = $userLoginsMapper->verifyCookie($cookie->login))) {
					// Authenticated via cookie data
					$setCookieHeader = new SetCookie(
						'login',
						$cookieData,
						(int)date('U', strtotime('+2 weeks'))
					);
					$e->getResponse()->getHeaders()->addHeader($setCookieHeader);
				}
			}
		}
	}
	
	/**
	 * Performs an ACL check, using the user's current role ('guest' if not logged in)
	 * against the current resource (the route name). Configured via the 'acl' key in
	 * the module config.
	 * 
	 * @param MvcEvent $e
	 * @throws \Exception
	 */
	public function checkAcl(MvcEvent $e)
	{
		$app = $e->getApplication();
		$sm = $app->getServiceManager();
		$acl = $sm->get('AclService');
		$auth = $sm->get('AuthService');
		$resource = $e->getRouteMatch()->getMatchedRouteName();
		
		$role = 'guest';
		if ($auth->hasIdentity()) {
			$role = $auth->getIdentity()->aclRole;
		}
		if ($resource === 'login') {
			// Skip the check if we are attempting to access the login page
			return;
		}
	
		if (!$acl->hasResource($resource)) {
			throw new \Exception('Undefined ACL resource: ' . $resource);
		}
		if (!$acl->isAllowed($role, $resource)) {
			// ACL role is not allowed to access this resource
			if ('guest' === $role) {
				// User is not logged in
				return $this->redirectToRoute($e, 'login');
			} else {
				// User is logged in, probably tried to access an admin-only resource
				return $this->redirectToRoute($e, 'home');
			}
		}
	}
	
	protected function redirectToRoute(MvcEvent $e, $routeName = 'login')
	{
		// Redirect to login page
		$loginUrl = $e->getRouter()->assemble(array(), array('name' => $routeName));
		$response = $e->getResponse();
		$response->getHeaders()->addHeaderLine('Location', $e->getRequest()->getBaseUrl() . $loginUrl);
		$response->setStatusCode('302');
			
		// Return a response to short-circuit the event manger and prevent a dispatch
		return $response;
	}
	
}
