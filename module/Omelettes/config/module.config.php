<?php

return array(
	'form_elements' => array(
		'invokables' => array(
			'staticValue' => 'Omelettes\Form\Element\StaticValue',
		),
	),
	'router' => array(
		'routes' => array(
		),
	),
	'service_manager' => array(
	),
	'controllers' => array(
		'invokables' => array(
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'flash-messenger'		=> __DIR__ . '/../view/partial/flash-messenger.phtml',
			'form/friendly'			=> __DIR__ . '/../view/partial/form/friendly.phtml',
			'form/horizontal'		=> __DIR__ . '/../view/partial/form/horizontal.phtml',
			'mail/layout/text'		=> __DIR__ . '/../view/mail/layout/text.phtml',
			'mail/layout/html'		=> __DIR__ . '/../view/mail/layout/html.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
