<?php

namespace OmelettesAuth;

use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl;
use OmelettesAuth\Form\ForgotPasswordFilter;
use OmelettesAuth\Form\LoginFilter;
use OmelettesAuth\Form\ResetPasswordFilter;
use OmelettesAuth\Storage\Session as StorageSession;
use OmelettesAuth\Model\User;
use OmelettesAuth\Model\UsersMapper;

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
				'OmelettesAuth\Storage\Session'	=> function($sm) {
					return new StorageSession(StorageSession::STORAGE_NAMESPACE);
				},
				'AuthService'				=> function($sm) {
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
				'UsersTableGateway'			=> function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new User());
					return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
				},
				'OmelettesAuth\Model\UsersMapper'	=> function($sm) {
					$gateway = $sm->get('UsersTableGateway');
					$mapper = new UsersMapper($gateway);
					return $mapper;
				},
				'OmelettesAuth\Form\LoginFilter'		=> function($sm) {
					$filter = new LoginFilter();
					return $filter;
				},
				'OmelettesAuth\Form\ForgotPasswordFilter'		=> function($sm) {
					$filter = new ForgotPasswordFilter($sm->get('OmelettesAuth\Model\UsersMapper'));
					return $filter;
				},
				'AclService'				=> function($sm) {
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
			),
		);
	}
	
	public function onBootstrap(MvcEvent $e)
	{
		$em = $e->getApplication()->getEventManager();
		$em->attach('route', array($this, 'checkAcl'));
	}
	
	public function checkAcl(MvcEvent $e)
	{
		$app = $e->getApplication();
		$sm = $app->getServiceManager();
		$acl = $sm->get('AclService');
		$auth = $sm->get('AuthService');
		$resource = $e->getRouteMatch()->getMatchedRouteName();
		$role = $auth->hasIdentity() ? $auth->getIdentity()->aclRole : 'guest';
		if (empty($role)) {
			$role = 'guest';
		}
		if ($resource === 'login') {
			return;
		}
	
		if (!$acl->hasResource($resource)) {
			throw new \Exception('Undefined ACL resource: ' . $resource);
		}
		if (!$acl->isAllowed($role, $resource)) {
			// Redirect to login page
			$loginUrl = $e->getRouter()->assemble(array(), array('name'=>'login'));
			$response = $e->getResponse();
			$response->getHeaders()->addHeaderLine('Location', $e->getRequest()->getBaseUrl() . $loginUrl);
			$response->setStatusCode('302');
		}
	}
	
}
