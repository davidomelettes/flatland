<?php

namespace FlatlandAdmin;

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
				'FlatlandAdmin\Form\AddUserFilter' => function ($sm) {
					$filter = new Form\AddUserFilter($sm->get('OmelettesSignup\Model\UsersMapper'));
					return $filter;
				},
				'FlatlandAdmin\Form\InviteUserFilter' => function ($sm) {
					$filter = new Form\InviteUserFilter(
						$sm->get('OmelettesSignup\Model\UsersMapper'),
						$sm->get('OmelettesSignup\Model\InvitationCodesMapper')
					);
					return $filter;
				},
				'FlatlandAdmin\Model\GamesMapper' => function ($sm) {
					$gateway = $sm->get('GamesTableGateway');
					$mapper = new Model\GamesMapper($gateway);
					return $mapper;
				},
				'FlatlandAdmin\Model\GamesMapper' => function ($sm) {
					$gateway = $sm->get('GamesTableGateway');
					$mapper = new Model\GamesMapper($gateway);
					return $mapper;
				},
				'FlatlandAdmin\Model\PublishersMapper' => function ($sm) {
					$gateway = $sm->get('PublishersTableGateway');
					$mapper = new Model\PublishersMapper($gateway);
					return $mapper;
				},
				'FlatlandAdmin\Form\AddPublisherFilter' => function ($sm) {
					$filter = new Form\AddPublisherFilter();
					return $filter;
				},
				'FlatlandAdmin\Model\DesignersMapper' => function ($sm) {
					$gateway = $sm->get('DesignersTableGateway');
					$mapper = new Model\DesignersMapper($gateway);
					return $mapper;
				},
				'FlatlandAdmin\Form\AddDesignerFilter' => function ($sm) {
					$filter = new Form\AddDesignerFilter();
					return $filter;
				},
			),
		);
	}
	
}
