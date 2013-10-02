<?php

return array(
	'acl' => array(
		'resources' => array(
			'user'		=> array(
				'user',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'User\Controller\User' => 'OmelettesUser\Controller\UserController',
		),
	),
	'router' => array(
		'routes' => array(
			'user' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/user[/:action]',
					'defaults'		=> array(
						'controller'	=> 'User\Controller\User',
						'action'		=> 'info',
					),
					'constraints'	=> array(),
				),
			),
		),
	),
	'service_manager' => array(
	),
	'view_helpers'	=> array(
		'invokables'	=> array(
		),
	),
	'view_manager' => array(
		'template_map' => array(
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
