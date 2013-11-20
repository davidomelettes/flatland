<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest'		=> array(
				'stub',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Stub\Controller\Stub' => 'Stub\Controller\StubController',
		),
	),
	'navigation' => array(
		'default' => array(
		),
	),
	'router' => array(
		'routes' => array(
			'stub' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/stub[/:action][/:key]',
					'constraints'	=> array(
						'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'Stub\Controller\Stub',
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
