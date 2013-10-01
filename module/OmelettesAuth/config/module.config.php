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
	'view_helpers' => array(
		'invokables' => array(
			'authService' => 'OmelettesAuth\View\Helper\AuthService',
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'mail/text/reset-password'		=> __DIR__ . '/../view/mail/reset-password.phtml',
			'mail/html/reset-password'		=> __DIR__ . '/../view/mail/html/reset-password.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
