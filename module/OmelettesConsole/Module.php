<?php

namespace OmelettesConsole;

use Zend\Console\Request as ConsoleRequest,
	Zend\Mvc\MvcEvent;

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
			),
		);
	}
	
	public function onBootstrap(MvcEvent $ev)
	{
		$em = $ev->getApplication()->getEventManager();
		$em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'consoleInfo'));
		$em->attach(MvcEvent::EVENT_FINISH, array($this, 'consoleFlash'));
	}
	
	public function consoleInfo(MvcEvent $ev)
	{
		$request = $ev->getRequest();
		if (!$request instanceof ConsoleRequest) {
			return;
		}
		
		echo "-- OMELETT.ES CONSOLE --\n";
		
		$app = $ev->getApplication();
		$sm = $app->getServiceManager();
		
		$auth = $sm->get('AuthService');
		if (!$auth->hasIdentity()) {
			echo "Not authenticated\n";
		} else {
			$id = $auth->getIdentity();
			printf("Authenticated as %s (Full Name: %s; key: %s)\n", $id->name, $id->fullName, $id->key);
		}
		
		echo "\n";
	}
	
	public function consoleFlash(MvcEvent $ev)
	{
		$request = $ev->getRequest();
		if (!$request instanceof ConsoleRequest) {
			return;
		}
		
		$app = $ev->getApplication();
		$sm = $app->getServiceManager();
		$config = $sm->get('config');
		$flash = $sm->get('ControllerPluginManager')->get('flashMessenger');
		
		$flash->setNamespace('error');
		if ($flash->hasCurrentMessages()) {
			echo "FLASH ERRORS:\n";
			foreach ($flash->getCurrentMessages() as $message) {
				printf("* %s\n", $message);
			}
			echo "\n";
		}
		
		$flash->setNamespace('success');
		if ($flash->hasCurrentMessages()) {
			echo "FLASH MESSAGES:\n";
			foreach ($flash->getCurrentMessages() as $message) {
				printf("* %s\n", $message);
			}
			echo "\n";
		}
	}
	
}
