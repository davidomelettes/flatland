<?php

return array(
	'acl' => array(
		'roles' => array(
			'guest'		=> array(),
			'user'		=> array('guest'),
			'admin'		=> array('user'),
			'super'		=> array('admin'),
			'system'	=> array('super'),
		),
		'resources' => array(
			'guest'		=> array(
				'login',
				'logout',
				'forgot-password',
				'reset-password',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Auth\Controller\Auth' => 'OmelettesAuth\Controller\AuthController',
		),
	),
	'router' => array(
		'routes' => array(
			'login' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/sign-in',
					'defaults'		=> array(
						'controller'	=> 'Auth\Controller\Auth',
						'action'		=> 'login',
					),
				),
			),
			'logout' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/sign-out',
					'defaults'		=> array(
						'controller'	=> 'Auth\Controller\Auth',
						'action'		=> 'logout',
					),
				),
			),
			'forgot-password' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/forgot-password',
					'defaults'		=> array(
						'controller'	=> 'Auth\Controller\Auth',
						'action'		=> 'forgot-password',
					),
				),
			),
			'reset-password' => array(
				'type'		=> 'Segment',
				'options'	=> array(
					'route'			=> '/reset-password/:user_key/:password_reset_key',
					'defaults'		=> array(
						'controller'	=> 'Auth\Controller\Auth',
						'action'		=> 'reset-password',
					),
					'constraints'	=> array(
						'user_key'				=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
						'passsword_reset_key'	=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
				),
			),
		),
	),
	'service_manager' => array(
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => array(
			/*
			'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
			*/
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
