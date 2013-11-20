<?php

namespace FlatlandList;

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
				'ListsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\TopList());
					return new TableGateway('lists', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandList\Model\TopListsMapper' => function ($sm) {
					$readGateway = $sm->get('ListsTableGateway');
					$writeGateway = $sm->get('ListsTableGateway');
					$mapper = new Model\TopListsMapper($readGateway, $writeGateway);
					return $mapper;
				},
			),
		);
	}
	
}
