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
	),
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);