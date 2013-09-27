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
	),
	'view_manager' => array(
	),
);
