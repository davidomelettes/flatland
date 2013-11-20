<?php

namespace Stub;

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
				'StubbyTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Stubby());
					return new TableGateway('stubby', $dbAdapter, null, $resultSetPrototype);
				},
				'Stub\Model\StubbyMapper' => function ($sm) {
					$readGateway = $sm->get('StubbyTableGateway');
					$writeGateway = $sm->get('StubbyTableGateway');
					$mapper = new Model\StubbyMapper($readGateway, $writeGateway);
					return $mapper;
				},
			),
		);
	}
	
}
