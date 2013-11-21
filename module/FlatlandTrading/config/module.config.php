<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest' => array(
				'trading' => array(),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Trading\Controller\Trades' => 'FlatlandTrading\Controller\TradesController',
		),
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Trading',
				'route' => 'trading',
				'icon'	=> 'shopping-cart',
			),
		),
	),
	'router' => array(
		'routes' => array(
			'trading' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/trading[/:action][/:key]',
					'constraints'	=> array(
						'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'Trading\Controller\Trades',
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
