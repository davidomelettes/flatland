<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'Game\Controller\Games' => 'Game\Controller\GamesController',
		),
	),
	'router' => array(
		'routes' => array(
			'games' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/games[/:id]',
					'constraints'	=> array(),
					'defaults'		=> array(
						'controller'	=> 'Game\Controller\Games',
					),
				),
			),
		),
	),
	'service_manager' => array(
		/*
		 * ????
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		*/
		'aliases' => array(
			'translator' => 'MvcTranslator',
		),
	),
	'translator' => array(
		'locale' => 'en_GB',
		'translation_file_patterns' => array(
			array(
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			),
		),
	),
	'view_manager' => array(
		'display_not_found_reason'	=> true,
		'display_exceptions'		=> true,
		'doctype'					=> 'HTML5',
		'not_found_template'		=> 'error/404',
		'exception_template'		=> 'error/index',
		'template_map'				=> array(
			'layout/layout'				=> __DIR__ . '/../view/layout/game.phtml',
			'error/404'					=> __DIR__ . '/../view/error/404.phtml',
			'error/index'				=> __DIR__ . '/../view/error/index.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
