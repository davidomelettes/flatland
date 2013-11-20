<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest'		=> array(
				'games',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Game\Controller\Games' => 'FlatlandGame\Controller\GamesController',
		),
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Games',
				'route' => 'games',
				'icon'	=> 'tower',
			),
		),
	),
	'router' => array(
		'routes' => array(
			'games' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/games[/:action][/:key]',
					'constraints'	=> array(
						'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'Game\Controller\Games',
						'action'		=> 'index',
					),
				),
			),
		),
	),
	'service_manager' => array(
	),
	'view_manager' => array(
		'template_map' => array(
			'tabulate/game'		=> __DIR__ . '/../view/partial/tabulate/game.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
