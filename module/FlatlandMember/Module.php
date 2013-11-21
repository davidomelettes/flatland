<?php

namespace FlatlandMember;

use Zend\Db\ResultSet\ResultSet,
	Zend\Db\TableGateway\TableGateway;

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
				'FlatlandMember\Model\MembersMapper' => function ($sm) {
					$readGateway = $sm->get('UsersViewGateway');
					$mapper = new Model\MembersMapper($readGateway);
					return $mapper;
				},
			),
		);
	}
	
}
