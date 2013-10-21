<?php

return array(
	'acl' => array(
		'resources' => array(
			'admin' => array(
				'admin/database'
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Admin\Controller\Database' => 'FlatlandAdmin\Controller\DatabaseController',
		),
	),
	'router' => array(
		'routes' => array(
			'admin' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/admin',
					'constraints'	=> array(),
					'defaults'		=> array(
						'controller'	=> 'Admin\Controller\Database',
						'action'		=> 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'database' => array(
						'type' => 'Segment',
						'options' => array(
							'route'			=> '/database[/:action][/:key]',
							'constraints'	=> array(
								'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
							),
							'defaults'		=> array(
								'controller'	=> 'Admin\Controller\Database',
								'action'		=> 'index',
							),
						),
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
