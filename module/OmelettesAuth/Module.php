<?php

namespace OmelettesAuth;

use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter,
	Zend\Console\Request as ConsoleRequest,
	Zend\Db\ResultSet\ResultSet,
	Zend\Db\TableGateway\TableGateway,
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
								foreach ($roleResources as $resource => $privileges) {
									if (!$acl->hasResource($resource)) {
										$acl->addResource(new Acl\Resource\GenericResource($resource));
									}
									$acl->allow($role, $resource, $privileges);
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
						"sha256(?||salt) AND acl_role != 'system'"
					);
				
					$authService = new Authentication\AuthenticationService();
					$authService->setAdapter($dbTableAuthAdapter);
					$authService->setStorage($sm->get('OmelettesAuth\Storage\Session'));
				
					return $authService;
				},
				'OmelettesAuth\Form\ForgotPasswordFilter' => function($sm) {
					$filter = new Form\ForgotPasswordFilter($sm->get('OmelettesAuth\Model\UsersMapper'));
					return $filter;
				},
				'OmelettesAuth\Form\LoginFilter' => function($sm) {
					$filter = new Form\LoginFilter();
					return $filter;
				},
				'OmelettesAuth\Model\UserLoginsMapper' => function($sm) {
					$gateway = $sm->get('UserLoginsTableGateway');
					$mapper = new Model\UserLoginsMapper($gateway);
					return $mapper;
				},
				'OmelettesAuth\Model\UsersMapper' => function($sm) {
					$gateway = $sm->get('UsersTableGateway');
					$mapper = new Model\UsersMapper($gateway);
					return $mapper;
				},
				'OmelettesAuth\Storage\Session' => function($sm) {
					return new Storage\Session(Storage\Session::STORAGE_NAMESPACE);
				},
				'UserLoginsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					return new TableGateway('user_logins', $dbAdapter, null, $resultSetPrototype);
				},
				'UsersTableGateway' => function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\User());
					return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
				},
			),
		);
	}
	
	public function onBootstrap(MvcEvent $ev)
	{
		$em = $ev->getApplication()->getEventManager();
		$em->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkAuth'));
		$em->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkAcl'));
	}
	
	/**
	 * Ensures that the auth identity is kept fresh
	 * Handles cookie-based authentication
	 * 
	 * @param MvcEvent $e
	 */
	public function checkAuth(MvcEvent $ev)
	{
		$app = $ev->getApplication();
		$sm = $app->getServiceManager();
		$config = $sm->get('config');
		$flash = $sm->get('ControllerPluginManager')->get('flashMessenger');
		$auth = $sm->get('AuthService');
		$authMapper = $sm->get('OmelettesAuth\Model\UsersMapper');
		
		$request = $ev->getRequest();
		if ($request instanceof ConsoleRequest) {
			// We're using the console
			// Log in as system user
			$systemIdentity = $authMapper->getSystemIdentity($config['user_keys']['SYSTEM_CONSOLE']);
			if (!$systemIdentity) {
				throw new \Exception('Missing console identity!');
			}
			$auth->getStorage()->write($systemIdentity);
			return;
		}
		
		// HTTP requests might provide a cookie
		$cookie = $request->getCookie();
		
		if ($auth->hasIdentity()) {
			// User is logged in, session is fresh
			$currentIdentity = $auth->getIdentity();
			if (false === ($freshIdentity = $authMapper->find($currentIdentity->key))) {
				// Can't find the user for some reason
				// Maybe they got deleted, so log them out
				$auth->clearIdentity();
				$flash->addErrorMessage('Your authentication idenitity was not found');
				return $this->redirectToRoute($ev, 'login');
			}
			// Refresh the identity
			if ($currentIdentity->isPasswordAuthenticated()) {
				$freshIdentity->setPasswordAuthenticated();
			}
			$auth->getStorage()->write($freshIdentity);
			
		} elseif ($cookie && $cookie->offsetExists('login')) {
			// No auth identity in the current session, but we have a login lookie
			// Attempt a cookie-based authentication
			$userLoginsMapper = $sm->get('OmelettesAuth\Model\UserLoginsMapper');
			try {
				if (FALSE !== ($refreshedCookieData = $userLoginsMapper->verifyCookie($cookie->login))) {
					// Authenticated via cookie data
					$data = $userLoginsMapper->splitCookieData($refreshedCookieData);
					
					// Refresh the cookie
					$auth->setLoginCookie($ev->getResponse(), $refreshedCookieData, $data['expiry']);
					
					// Fetch authentication identity
					if (FALSE !== ($user = $authMapper->findByName($data['name']))) {
						// Authenticated identity IS NOT password authenticated!
						$auth->getStorage()->write($user);
					} else {
						$auth->removeLoginCookie($ev->getResponse());
						throw new \Exception('Failed to authenticate using cookie data');
					}
				} else {
					$auth->removeLoginCookie($ev->getResponse());
					return;
				}
			} catch (Exception\UserLoginTheftException $e) {
				// The provided login cookie has a known series but an unknown token; possible cookie theft
				// Attempt to remove the cookie
				$auth->removeLoginCookie($ev->getResponse());
				// Give the user some warning
				return $this->redirectToRoute($ev, 'login-theft-warning');
			}
		} else {
			// No identity in session or cookie; user is not logged in
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
	public function checkAcl(MvcEvent $ev)
	{
		$app = $ev->getApplication();
		$sm = $app->getServiceManager();
		$acl = $sm->get('AclService');
		$auth = $sm->get('AuthService');
		$flash = $sm->get('ControllerPluginManager')->get('flashMessenger');
		
		$resource = $ev->getRouteMatch()->getMatchedRouteName();
		if ($resource === 'login') {
			// Skip the check if we are attempting to access the login page
			return;
		}
		$privilege = $ev->getRouteMatch()->getParam('action', 'index');
		
		$role = 'guest';
		if ($auth->hasIdentity()) {
			$role = $auth->getIdentity()->aclRole;
		}
		if (!$acl->hasResource($resource)) {
			throw new \Exception('Undefined ACL resource: ' . $resource);
		}
		if (!$acl->isAllowed($role, $resource, $privilege)) {
			// ACL role is not allowed to access this resource/privilege
			if ('guest' === $role) {
				// User is not logged in
				$flash->addErrorMessage('You must be logged in to access that page');
				return $this->redirectToRoute($ev, 'login');
			} else {
				// User is logged in, probably tried to access an admin-only resource/privilege
				$flash->addErrorMessage('You do not have permission to access that page');
				return $this->redirectToRoute($ev, 'home');
			}
		}
	}
	
	protected function redirectToRoute(MvcEvent $ev, $routeName = 'login')
	{
		// Redirect to login page
		$loginUrl = $ev->getRouter()->assemble(array(), array('name' => $routeName));
		$response = $ev->getResponse();
		$response->getHeaders()->addHeaderLine('Location', $ev->getRequest()->getBaseUrl() . $loginUrl);
		$response->setStatusCode('302');
			
		// Return a response to short-circuit the event manger and prevent a dispatch
		return $response;
	}
	
}
