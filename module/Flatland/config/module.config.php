<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest' => array(
				'home',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Flatland\Controller\Home' => 'Flatland\Controller\HomeController',
		),
	),
	'router' => array(
		'routes' => array(
			'home' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/',
					'defaults'		=> array(
						'controller'	=> 'Flatland\Controller\Home',
						'action'		=> 'home',
					),
				),
			),
		),
	),
	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'aliases' => array(
			'translator' => 'MvcTranslator',
		),
	),
	'translator' => array(
		'locale'					=> 'en_GB',
		'translation_file_patterns' => array(
			array(
				'type'		=> 'gettext',
				'base_dir'	=> __DIR__ . '/../language',
				'pattern'	=> '%s.mo',
			),
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => array(
			/*
			'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
			*/
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
