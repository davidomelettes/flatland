<?php

namespace OmelettesSignup;

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
				'InvitationCodesTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\InvitationCode());
					return new TableGateway('invitation_codes', $dbAdapter, null, $resultSetPrototype);
				},
				'OmelettesSignup\Model\InvitationCodesMapper' => function ($sm) {
					$gateway = $sm->get('InvitationCodesTableGateway');
					$mapper = new Model\InvitationCodesMapper($gateway);
					return $mapper;
				},
				'SignupUsersTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\User());
					return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
				},
				'OmelettesSignup\Model\UsersMapper' => function ($sm) {
					$gateway = $sm->get('SignupUsersTableGateway');
					$mapper = new Model\UsersMapper($gateway);
					return $mapper;
				},
				'OmelettesSignup\Form\SignupFilter' => function ($sm) {
					$filter = new Form\SignupFilter(
						$sm->get('OmelettesSignup\Model\UsersMapper'),
						$sm->get('OmelettesSignup\Model\InvitationCodesMapper')
					);
					return $filter;
				},
			),
		);
	}
	
}
