<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest'		=> array(
				'groups',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Group\Controller\Groups' => 'FlatlandGroup\Controller\GroupsController',
		),
	),
	'navigation' => array(
		'default' => array(
		),
	),
	'router' => array(
		'routes' => array(
			'groups' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/groups[/:action][/:key]',
					'constraints'	=> array(
						'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'Group\Controller\Groups',
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
