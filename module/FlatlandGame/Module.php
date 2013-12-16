<?php

namespace FlatlandGame;

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
				// Games
				'GamesTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Game());
					return new TableGateway('games', $dbAdapter, null, $resultSetPrototype);
				},
				'GamesViewGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Game());
					return new TableGateway('games_view', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandGame\Model\GamesMapper' => function ($sm) {
					$readGateway = $sm->get('GamesViewGateway');
					$writeGateway = $sm->get('GamesTableGateway');
					$mapper = new Model\GamesMapper($readGateway, $writeGateway);
					return $mapper;
				},
				
				// Designers
				'DesignersTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Designer());
					return new TableGateway('designers', $dbAdapter, null, $resultSetPrototype);
				},
				
				// Publishers
				'PublishersTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Publisher());
					return new TableGateway('publishers', $dbAdapter, null, $resultSetPrototype);
				},
				
				// Forums
				'GameForumThreadsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Thread());
					return new TableGateway('threads', $dbAdapter, null, $resultSetPrototype);
				},
				'GameForumThreadsViewGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Thread());
					return new TableGateway('threads_view', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandGame\Model\ThreadsMapper' => function ($sm) {
					$readGateway = $sm->get('GameForumThreadsViewGateway');
					$writeGateway = $sm->get('GameForumThreadsTableGateway');
					$mapper = new Model\ThreadsMapper($readGateway, $writeGateway);
					return $mapper;
				},
			),
		);
	}
	
}
