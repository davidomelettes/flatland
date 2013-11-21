<?php

namespace FlatlandGroup;

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
				'GroupsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Group());
					return new TableGateway('groups', $dbAdapter, null, $resultSetPrototype);
				},
				'GroupsViewGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Group());
					return new TableGateway('groups_view', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandGroup\Model\GroupsMapper' => function ($sm) {
					$readGateway = $sm->get('GroupsViewGateway');
					$writeGateway = $sm->get('GroupsTableGateway');
					$mapper = new Model\GroupsMapper($readGateway, $writeGateway);
					return $mapper;
				},
				'FlatlandGroup\Form\AddGroupFilter' => function ($sm) {
					$filter = new Form\AddGroupFilter();
					return $filter;
				},
			),
		);
	}
	
}
