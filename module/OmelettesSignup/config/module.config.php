<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest' => array(
				'signup' => array(),
				'about' => array(),
				'terms' => array(),
			), 
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Signup\Controller\Signup' => 'OmelettesSignup\Controller\SignupController',
			'Signup\Controller\Pages' => 'OmelettesSignup\Controller\PagesController',
		),
	),
	'router' => array(
		'routes' => array(
			'signup' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/sign-up',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'signup',
					),
				),
			),
			'about' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/about',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Pages',
						'action'		=> 'about',
					),
				),
			),
			'terms' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/terms',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Pages',
						'action'		=> 'terms',
					),
				),
			),
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'tabulate/invitation'		=> __DIR__ . '/../view/partial/tabulate/invitation.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	'layout' => array(
		'signup' => 'layout/signup',
	),
);
