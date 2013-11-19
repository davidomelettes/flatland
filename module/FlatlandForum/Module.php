<?php

namespace FlatlandForum;

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
				'ForumsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Forum());
					return new TableGateway('forums', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandForum\Model\ForumsMapper' => function ($sm) {
					$readGateway = $sm->get('ForumsTableGateway');
					$mapper = new Model\ForumsMapper($readGateway);
					return $mapper;
				},
			),
		);
	}
	
}
