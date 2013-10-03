<?php

namespace OmelettesUser;

use OmelettesUser\Form\UserInfoForm,
	OmelettesUser\Model\UserMapper;

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
				'OmelettesUser\Model\UserMapper' => function ($sm) {
					$gateway = $sm->get('UsersTableGateway');
					$mapper = new UserMapper($gateway);
					return $mapper;
				},
			),
		);
	}
	
}
