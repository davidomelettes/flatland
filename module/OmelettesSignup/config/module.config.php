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
		'template_map' => array(
			'tabulate/invitation'		=> __DIR__ . '/../view/partial/tabulate/invitation.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
