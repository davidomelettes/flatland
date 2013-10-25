<?php

namespace OmelettesConsole;

use Zend\Console\Adapter\AdapterInterface as Console,
	Zend\Console\Request as ConsoleRequest,
	Zend\ModuleManager\Feature\ConsoleBannerProviderInterface,
	Zend\ModuleManager\Feature\ConsoleUsageProviderInterface,
	Zend\Mvc\MvcEvent;

class Module implements ConsoleBannerProviderInterface, ConsoleUsageProviderInterface
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
				'OmelettesConsole\Migration\Sql' => function ($sm) {
					$migration = new Migration\Sql();
					$migration->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
					return $migration;
				},
			),
		);
	}
	
	public function getConsoleBanner(Console $console)
	{
		return
			"==------------------------------------------------------==\n" .
			"==        OMELETT.ES QUANTUM APPLICATION CONSOLE        ==\n" .
			"==------------------------------------------------------=="
		;
	}
	
	public function getConsoleUsage(Console $console)
	{
		return array(
			'db migrate [--test] <version>'	=> 'Execute migration file',
		);
	}
	
	public function onBootstrap(MvcEvent $ev)
	{
		$em = $ev->getApplication()->getEventManager();
		//$em->attach(MvcEvent::EVENT_FINISH, array($this, 'consoleFlash'));
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
