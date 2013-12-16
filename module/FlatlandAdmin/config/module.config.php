<?php

return array(
	'acl' => array(
		'resources' => array(
			'admin' => array(
				'admin' => array(),
				'admin/designers' => array(),
				'admin/forums' => array(),
				'admin/games' => array(),
				'admin/invites' => array(),
				'admin/publishers' => array(),
				'admin/users' => array(),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Admin\Controller\Designers' => 'FlatlandAdmin\Controller\DesignersController',
			'Admin\Controller\Forums' => 'FlatlandAdmin\Controller\ForumsController',
			'Admin\Controller\Games' => 'FlatlandAdmin\Controller\GamesController',
			'Admin\Controller\Invites' => 'FlatlandAdmin\Controller\InvitationsController',
			'Admin\Controller\Publishers' => 'FlatlandAdmin\Controller\PublishersController',
			'Admin\Controller\Users' => 'FlatlandAdmin\Controller\UsersController',
		),
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Database',
				'route' => 'admin/games',
				'icon'	=> 'book',
				'class' => 'dropdown',
				'pages' => array(
					array(
						'label' => 'Forums',
						'route' => 'admin/forums',
					),
					array(
						'label' => 'Games',
						'route' => 'admin/games',
					),
					array(
						'label' => 'Designers',
						'route' => 'admin/designers',
					),
					array(
						'label' => 'Publishers',
						'route' => 'admin/publishers',
					),
					array(
						'label' => 'Users',
						'route' => 'admin/users',
					),
				),
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
					'designers' => array(
						'type' => 'Segment',
						'options' => array(
							'route'			=> '/designers[/:action][/:key]',
							'constraints'	=> array(
								'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
							),
							'defaults'		=> array(
								'controller'	=> 'Admin\Controller\Designers',
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
					'invites' => array(
						'type' => 'Segment',
						'options' => array(
							'route'			=> '/invites[/:action][/:key]',
							'constraints'	=> array(
								'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
							),
							'defaults'		=> array(
								'controller'	=> 'Admin\Controller\Invites',
								'action'		=> 'index',
							),
						),
					),
					'forums' => array(
						'type' => 'Segment',
						'options' => array(
							'route'			=> '/forums[/:action][/:key]',
							'constraints'	=> array(
								'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
							),
							'defaults'		=> array(
								'controller'	=> 'Admin\Controller\Forums',
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
			'tabulate/admin-game'		=> __DIR__ . '/../view/partial/tabulate/game.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
