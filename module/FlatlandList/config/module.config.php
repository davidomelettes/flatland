<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest'		=> array(
				'lists' => array(),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'List\Controller\Lists' => 'FlatlandList\Controller\ListsController',
		),
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Lists',
				'route' => 'lists',
				'icon'	=> 'list',
			),
		),
	),
	'router' => array(
		'routes' => array(
			'lists' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/lists[/:action][/:key]',
					'constraints'	=> array(
						'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'List\Controller\Lists',
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
