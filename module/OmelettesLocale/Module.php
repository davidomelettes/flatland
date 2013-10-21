<?php

namespace OmelettesLocale;

use OmelettesLocale\Model\Locale,
	OmelettesLocale\Model\LocaleLanguage,
	OmelettesLocale\Model\LocaleLanguagesMapper,
	OmelettesLocale\Model\LocalesMapper;
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
				'LocalesTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Locale());
					return new TableGateway('locales_view', $dbAdapter, null, $resultSetPrototype);
				},
				'UserSecondaryLocalesTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Locale());
					return new TableGateway('user_locales_view', $dbAdapter, null, $resultSetPrototype);
				},
				'LocaleLanguagesTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new LocaleLanguage());
					return new TableGateway('locale_languages', $dbAdapter, null, $resultSetPrototype);
				},
				'OmelettesLocale\Model\LocalesMapper' => function ($sm) {
					$gateway = $sm->get('LocalesTableGateway');
					$dependencies = array(
						'user_secondary_locales' => 'UserSecondaryLocalesTableGateway',
					);
					$mapper = new LocalesMapper($gateway, $dependencies);
					return $mapper;
				},
				'OmelettesLocale\Model\LocaleLanguagesMapper' => function ($sm) {
					$gateway = $sm->get('LocaleLanguagesTableGateway');
					$mapper = new LocaleLanguagesMapper($gateway);
					return $mapper;
				},
			),
		);
	}
	
}
