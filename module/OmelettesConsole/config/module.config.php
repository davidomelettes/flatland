<?php

return array(
	'acl' => array(
		'resources' => array(
			'system' => array(
				'migrate' => array(),
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
						'route' => 'db migrate [--commit] [--all]',
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
