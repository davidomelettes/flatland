<?php

namespace Omelettes;

class Module
{
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
	
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig()
	{
		return array(
			'aliases'		=> array(
				'Mailer'		=> 'Omelettes\Mailer',
			),
			'factories' => array(
				'Omelettes\Mailer'		=> function ($sm) {
					$config = $sm->get('config');
					$defaultAddress = $config['email_addresses']['SYSTEM_NOREPLY'];
					$mailer = new Mailer();
					$mailer->setTextLayout('mail/layout/text')
						->setHtmlLayout('mail/layout/html')
						->setFromAddress($defaultAddress['email'])
						->setFromName($defaultAddress['name']);
					return $mailer;
				},
			),
		);
	}
	
}
