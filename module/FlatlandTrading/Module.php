<?php

namespace FlatlandTrading;

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
				'TradesTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Trade());
					return new TableGateway('trades', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandTrading\Model\TradesMapper' => function ($sm) {
					$readGateway = $sm->get('TradesTableGateway');
					$writeGateway = $sm->get('TradesTableGateway');
					$mapper = new Model\TradesMapper($readGateway, $writeGateway);
					return $mapper;
				},
			),
		);
	}
	
}
