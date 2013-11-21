<?php

return array(
	'acl' => array(
		'resources' => array(
			'guest'		=> array(
				'members' => array(),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Member\Controller\Members' => 'FlatlandMember\Controller\MembersController',
		),
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Members',
				'route' => 'members',
				'icon'	=> 'user',
			),
		),
	),
	'router' => array(
		'routes' => array(
			'members' => array(
				'type' => 'Segment',
				'options' => array(
					'route'			=> '/members[/:action][/:key]',
					'constraints'	=> array(
						'key'			=> Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
					),
					'defaults'		=> array(
						'controller'	=> 'Member\Controller\Members' ,
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
			'tabulate/member'		=> __DIR__ . '/../view/partial/tabulate/member.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
