<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest'		=> array(
				'forums' => array(),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Forum\Controller\Forums' => 'FlatlandForum\Controller\ForumsController',
		),
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Forums',
				'route' => 'forums',
				'icon'	=> 'comment',
			),
		),
	),
	'router' => array(
		'routes' => array(
			'forums' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/forums[/:action][/:key]',
					'constraints'	=> array(
						'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'Forum\Controller\Forums',
						'action'		=> 'index',
					),
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
