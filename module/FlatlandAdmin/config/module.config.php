<?php

return array(
	'acl' => array(
		'resources' => array(
			'admin' => array(
				'admin/games',
				'admin/publishers',
				'admin/users',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Admin\Controller\Games' => 'FlatlandAdmin\Controller\GamesController',
			'Admin\Controller\Publishers' => 'FlatlandAdmin\Controller\PublishersController',
			'Admin\Controller\Users' => 'FlatlandAdmin\Controller\UsersController',
		),
	),
	'navigation' => array(
		'default' => array(),
		'admin_navigation' => array(
			array(
				'label' => 'Database',
				'route' => 'admin/games',
				'icon'	=> 'book',
				'pages' => array(
					array(
						'label' => 'Games',
						'route' => 'admin/games',
					),
					array(
						'label' => 'Publishers',
						'route' => 'admin/publishers',
					),
				),
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
						'controller'	=> 'Admin\Controller\Games',
						'action'		=> 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'games' => array(
						'type' => 'Segment',
						'options' => array(
							'route'			=> '/games[/:action][/:key]',
							'constraints'	=> array(
								'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
							),
							'defaults'		=> array(
								'controller'	=> 'Admin\Controller\Games',
								'action'		=> 'index',
							),
						),
					),
					'publishers' => array(
						'type' => 'Segment',
						'options' => array(
							'route'			=> '/publishers[/:action][/:key]',
							'constraints'	=> array(
								'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
							),
							'defaults'		=> array(
								'controller'	=> 'Admin\Controller\Publishers',
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
