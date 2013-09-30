<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest' => array(
				'signup',
			), 
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Signup\Controller\Signup' => 'OmelettesSignup\Controller\SignupController',
		),
	),
	'router' => array(
		'routes' => array(
			'signup' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/sign-up',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'signup',
					),
				),
			),
		),
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
