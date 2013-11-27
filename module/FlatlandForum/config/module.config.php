<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest'		=> array(
				'forums' => array(),
				'threads' => array('index', 'view'),
			),
			'user' => array(
				'threads' => array(),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Forum\Controller\Forums' => 'FlatlandForum\Controller\ForumsController',
			'Forum\Controller\Threads' => 'FlatlandForum\Controller\ThreadsController',
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
					'route'			=> '/forums[/:slug][/:action]',
					'constraints'	=> array(
						'slug'			=> Omelettes\Validator\Slug::SLUG_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'Forum\Controller\Forums',
						'action'		=> 'index',
					),
				),
			),
			'threads' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/topics[/:action][/:key]',
					'constraints'	=> array(
						'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'Forum\Controller\Threads',
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
			'tabulate/forum'		=> __DIR__ . '/../view/partial/tabulate/forum.phtml',
			'tabulate/thread'		=> __DIR__ . '/../view/partial/tabulate/thread.phtml',
			'tabulate/post'			=> __DIR__ . '/../view/partial/tabulate/post.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
