<?php

namespace Omelettes;

use Zend\Log\Writer;

class Module
{
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__					=> __DIR__ . '/src/' . __NAMESPACE__,
					__NAMESPACE__.'Migration'		=> 'migration_next',
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
					$logWriter = new Writer\Stream('php://output');
					$logger = new Logger();
					$logger->addWriter($logWriter);
					return $logger;
				},
			),
		);
	}
	
}
