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
				'MembersViewGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Member());
					return new TableGateway('users_view', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandMember\Model\MembersMapper' => function ($sm) {
					$readGateway = $sm->get('MembersViewGateway');
					$mapper = new Model\MembersMapper($readGateway);
					return $mapper;
				},
			),
		);
	}
	
}
