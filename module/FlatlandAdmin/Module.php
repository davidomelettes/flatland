<?php

namespace FlatlandAdmin;

use FlatlandAdmin\Form,
	FlatlandAdmin\Model;
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
				'FlatlandAdmin\Form\AddGameFilter' => function ($sm) {
					$filter = new Form\AddGameFilter();
					return $filter;
				},
				'FlatlandAdmin\Form\GameVariantFilter' => function ($sm) {
					$filter = new Form\GameVariantFilter();
					return $filter;
				},
				'FlatlandAdmin\Model\GamesMapper' => function ($sm) {
					$gateway = $sm->get('GamesTableGateway');
					$mapper = new Model\GamesMapper($gateway);
					return $mapper;
				},
				'FlatlandAdmin\Model\GameVariantsMapper' => function ($sm) {
					$gateway = $sm->get('GameVariantsTableGateway');
					$mapper = new Model\GameVariantsMapper($gateway);
					return $mapper;
				},
				'GamesTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Game());
					return new TableGateway('games', $dbAdapter, null, $resultSetPrototype);
				},
				'GameVariantsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\GameVariant());
					return new TableGateway('game_variants', $dbAdapter, null, $resultSetPrototype);
				},
			),
		);
	}
	
}
