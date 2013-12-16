<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest' => array(
				'games' => array(),
				'games/game' => array(),
				'games/game/forum' => array(),
				'games/game/forum/topic' => array(),
				'games/game/lists' => array(),
			),
			'user' => array(
				'games/game/forum/new-topic' => array(),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Game\Controller\Games' => 'FlatlandGame\Controller\GamesController',
			'Game\Controller\GameForum' => 'FlatlandGame\Controller\GameForumController',
			'Game\Controller\GameLists' => 'FlatlandGame\Controller\GameListsController',
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
					'route'			=> '/games',
					'constraints'	=> array(),
					'defaults'		=> array(
						'controller'	=> 'Game\Controller\Games',
						'action'		=> 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'game' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/:slug',
							'defaults'		=> array(
								'controller'	=> 'Game\Controller\Games',
								'action'		=> 'view',
							),
						),
						'may_terminate' => true,
						'child_routes' => array(
							'forum' => array(
								'type' => 'Segment',
								'options' => array(
									'route' => '/forum',
									'defaults'		=> array(
										'controller'	=> 'Game\Controller\GameForum',
										'action'		=> 'index',
									),
								),
								'may_terminate' => true,
								'child_routes' => array(
									'new-topic' => array(
										'type' => 'Segment',
										'options' => array(
											'route' => '/new-topic',
											'defaults' => array(
												'action' => 'add'
											),
										),
									),
									'topic' => array(
										'type' => 'Segment',
										'options' => array(
											'route' => '/:topic_key[/:topic_slug]',
											'defaults' => array(
												'action' => 'view'
											),
											'constraints' => array(
												'key' => Omelettes\Validator\Uuid\V4::UUID_REGEX_PATTERN,
											),
										),
									),
								),
							),
							'lists' => array(
								'type' => 'Segment',
								'options' => array(
									'route' => '/lists',
									'defaults'		=> array(
										'controller'	=> 'Game\Controller\GameLists',
										'action'		=> 'index',
									),
								),
							),
						),
					),
				),
			),
		),
	),
	'service_manager' => array(
	),
	'view_manager' => array(
		'template_map' => array(
			'tabulate/game' => __DIR__ . '/../view/partial/tabulate/game.phtml',
			'tabulate/thread-game' => __DIR__ . '/../view/partial/tabulate/thread-game.phtml',
			'navigation-game' => __DIR__ . '/../view/partial/navigation-game.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
