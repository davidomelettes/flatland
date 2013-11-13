<?php

return array(
	'acl' => array(
		'resources' => array(
			'admin' => array(
				'admin/database',
				'admin/users',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Admin\Controller\Database' => 'FlatlandAdmin\Controller\DatabaseController',
			'Admin\Controller\Users' => 'FlatlandAdmin\Controller\UsersController',
		),
	),
	'navigation' => array(
		'default' => array(),
		'admin_navigation' => array(
			array(
				'label' => 'Database',
				'route' => 'admin/database',
				'icon'	=> 'book',
			),
			array(
				'label' => 'Users',
				'route' => 'admin/users',
				'icon'	=> 'user',
			),
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
					'users' => array(
						'type' => 'Segment',
						'options' => array(
							'route'			=> '/users[/:action][/:key]',
							'constraints'	=> array(
								'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
							),
							'defaults'		=> array(
								'controller'	=> 'Admin\Controller\Users',
								'action'		=> 'index',
							),
						),
					),
				),
			),
		),
	),
	'service_manager' => array(
		'factories' => array(
			'admin_navigation' => 'FlatlandAdmin\Navigation\Service\AdminNavigationFactory',
		),
	),
	'view_helpers'	=> array(
		'invokables'	=> array(
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'mail/text/invitation'		=> __DIR__ . '/../view/mail/invitation.phtml',
			'mail/html/invitation'		=> __DIR__ . '/../view/mail/html/invitation.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
