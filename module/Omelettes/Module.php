<?php

namespace Omelettes;

use Omelettes\Session\SaveHandler\DbTableGateway as SessionSaveHandlerDb;
use Zend\Console\Request as ConsoleRequest,
	Zend\Db\TableGateway\TableGateway,
	Zend\Log\Filter,
	Zend\Log\Writer,
	Zend\Mvc\MvcEvent,
	Zend\Session\Container,
	Zend\Session\SaveHandler\DbTableGatewayOptions,
	Zend\Session\SessionManager;

class Module
{
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__					=> __DIR__ . '/src/' . __NAMESPACE__,
					__NAMESPACE__.'Migration'		=> 'migration',
				),
			),
		);
	}
	
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig()
	{
		return array(
			'aliases'		=> array(
				'Mailer'		=> 'Omelettes\Mailer',
				'Logger'		=> 'Omelettes\Logger',
			),
			'factories' => array(
				'Omelettes\Mailer' => function ($sm) {
					$config = $sm->get('config');
					$defaultAddress = $config['email_addresses']['SYSTEM_NOREPLY'];
					$mailer = new Mailer();
					$mailer->setTextLayout('mail/layout/text')
						->setHtmlLayout('mail/layout/html')
						->setFromAddress($defaultAddress['email'])
						->setFromName($defaultAddress['name']);
					return $mailer;
				},
				'Omelettes\Logger' => function ($sm) {
					$config = $sm->get('config');
					$logWriter = new Writer\Stream('php://output');
					if (isset($config['log_levels']['stream'])) {
						$filter = new Filter\Priority($config['log_levels']['stream']);
						$logWriter->addFilter($filter);
					}
					$logger = new Logger();
					$logger->addWriter($logWriter);
					return $logger;
				},
				'SessionsTableGateway'			=> function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new TableGateway('sessions', $dbAdapter);
				},
				'Omelettes\Session\SaveHandler\DbTableGateway'	=> function ($sm) {
					$config = $sm->get('config');
					if (isset($config['session'])) {
						$session = $config['session'];
				
						$tableGateway = $sm->get('SessionsTableGateway');
						$sessionSaveHandler = new SessionSaveHandlerDb($tableGateway, new DbTableGatewayOptions());
					} else {
						throw new \Exception('Missing session config');
					}
					return $sessionSaveHandler;
				},
				'Zend\Session\SessionManager'	=> function ($sm) {
					$config = $sm->get('config');
					if (isset($config['session'])) {
						$session = $config['session'];
						
						$sessionConfig = null;
						if (isset($session['config'])) {
							$class = isset($session['config']['class']) ?
								$session['config']['class'] :
								'Zend\Session\Config\SessionConfig';
							$options = isset($session['config']['options']) ?
								$session['config']['options'] :
								array();
							$sessionConfig = new $class();
							$sessionConfig->setOptions($options);
						}
						
						$sessionStorage = null;
						if (isset($session['storage'])) {
							$class = $session['storage'];
							$sessionStorage = new $class();
						}
						
						$sessionSaveHandler = null;
						if (isset($session['save_handler'])) {
							// class should be fetched from service manager since it will require constructor arguments
							$sessionSaveHandler = $sm->get($session['save_handler']);
						}
						
						$sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
						
						if (isset($session['validator'])) {
							$chain = $sessionManager->getValidatorChain();
							foreach ($session['validator'] as $validator) {
								$validator = new $validator();
								$chain->attach('session.validate', array($validator, 'isValid'));
						
							}
						}
					} else {
						$sessionManager = new SessionManager();
					}
					Container::setDefaultManager($sessionManager);
					return $sessionManager;
				},
			),
		);
	}
	
	public function onBootstrap(MvcEvent $ev)
	{
		$this->bootstrapSession($ev);
		
		$app = $ev->getParam('application');
		$app->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, array($this, 'setLayout'));
	}
	
	public function bootstrapSession(MvcEvent $ev)
	{
		if ($ev->getRequest() instanceof ConsoleRequest) {
			// Use PHP default session handling for console requests
			return;
		}
		
		$session = $ev->getApplication()->getServiceManager()->get('Zend\Session\SessionManager');
		$session->start();
		
		$container = new Container('initialized');
		if (!isset($container->init)) {
			$session->regenerateId(true);
			$container->init = 1;
		}
	}
	
	public function setLayout(MvcEvent $ev)
	{
		$config = $ev->getApplication()->getServiceManager()->get('config');
		if (!isset($config['layout'])) {
			return;
		}
		$layoutConfig = $config['layout'];
		
		$routeName = $ev->getRouteMatch()->getMatchedRouteName();
		if (isset($layoutConfig[$routeName])) {
			$viewModel = $ev->getViewModel();
			$viewModel->setTemplate($layoutConfig[$routeName]);
		}
	}
	
}
