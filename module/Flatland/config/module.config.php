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
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Games',
				'route' => 'games',
				'icon'	=> 'tower',
			),
			array(
				'label' => 'Forums',
				'route' => 'home',
				'icon'	=> 'comment',
			),
			array(
				'label' => 'Trading',
				'route' => 'home',
				'icon'	=> 'shopping-cart',
			),
			array(
				'label' => 'Groups & Events',
				'route' => 'home',
				'icon'	=> 'calendar',
			),
			array(
				'label' => 'Lists',
				'route' => 'home',
				'icon'	=> 'list',
			),
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
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => array(
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
);
