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
				// Forums
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
				
				// Threads
				'FlatlandForum\Form\AddThreadFilter' => function ($sm) {
					$filter = new Form\AddThreadFilter();
					return $filter;
				},
				'ThreadsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Thread());
					return new TableGateway('threads', $dbAdapter, null, $resultSetPrototype);
				},
				'ThreadsViewGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Thread());
					return new TableGateway('threads_view', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandForum\Model\ThreadsMapper' => function ($sm) {
					$readGateway = $sm->get('ThreadsViewGateway');
					$writeGateway = $sm->get('ThreadsTableGateway');
					$mapper = new Model\ThreadsMapper($readGateway, $writeGateway);
					return $mapper;
				},
				
				// Posts
				'FlatlandForum\Form\PostFieldsetFilter' => function ($sm) {
					$filter = new Form\PostFieldsetFilter();
					return $filter;
				},
				'FlatlandForum\Form\ReplyFilter' => function ($sm) {
					$filter = new Form\ReplyFilter();
					return $filter;
				},
				'PostsTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Post());
					return new TableGateway('posts', $dbAdapter, null, $resultSetPrototype);
				},
				'PostsViewGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Post());
					return new TableGateway('posts_view', $dbAdapter, null, $resultSetPrototype);
				},
				'FlatlandForum\Model\PostsMapper' => function ($sm) {
					$readGateway = $sm->get('PostsViewGateway');
					$writeGateway = $sm->get('PostsTableGateway');
					$mapper = new Model\PostsMapper($readGateway, $writeGateway);
					return $mapper;
				},
			),
		);
	}
	
}
