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
				// Lists
				'FlatlandList\Form\AddTopListFilter' => function ($sm) {
					$filter = new Form\AddTopListFilter();
					return $filter;
				},
				'ListsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\TopList());
					return new TableGateway('lists', $dbAdapter, null, $resultSetPrototype);
				},
				'ListsViewGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\TopList());
					return new TableGateway('lists_view', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandList\Model\TopListsMapper' => function ($sm) {
					$readGateway = $sm->get('ListsViewGateway');
					$writeGateway = $sm->get('ListsTableGateway');
					$mapper = new Model\TopListsMapper($readGateway, $writeGateway);
					return $mapper;
				},
				
				// List items
				'FlatlandList\Form\AddListItemFilter' => function ($sm) {
					$filter = new Form\AddListItemFilter($sm->get('FlatlandGame\Model\GamesMapper'));
					return $filter;
				},
				'ListItemsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\ListItem());
					return new TableGateway('list_items', $dbAdapter, null, $resultSetPrototype);
				},
				'ListItemsViewGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\ListItem());
					return new TableGateway('list_items_view', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandList\Model\ListItemsMapper' => function ($sm) {
					$readGateway = $sm->get('ListItemsViewGateway');
					$writeGateway = $sm->get('ListItemsTableGateway');
					$mapper = new Model\ListItemsMapper($readGateway, $writeGateway);
					return $mapper;
				},
			),
		);
	}
	
}
