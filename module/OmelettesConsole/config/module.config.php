<?php

return array(
	'acl' => array(
		'resources' => array(
			'system' => array(
				'migrate',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Console\Controller\Migration' => 'OmelettesConsole\Controller\MigrationController',
		),
	),
	'console' => array(
		'router' => array(
			'routes' => array(
				'migrate' => array(
					'options' => array(
						'route' => 'db migrate [--test] <sequence>',
						'defaults' => array(
							'controller' => 'Console\Controller\Migration',
							'action' => 'migrate',
						),
					),
				),
			),
		),
	),
	'router' => array(
		'routes' => array(
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
