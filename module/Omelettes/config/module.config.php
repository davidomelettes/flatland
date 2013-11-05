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
	'validators' => array(
		'invokables' => array(
			'Password' => 'Omelettes\Validator\Password',
		),
	),
	'view_helpers'	=> array(
		'invokables'	=> array(
			'tabulate' => 'Omelettes\View\Helper\Tabulate',
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'flash-messenger'		=> __DIR__ . '/../view/partial/flash-messenger.phtml',
			'form/friendly'			=> __DIR__ . '/../view/partial/form/friendly.phtml',
			'form/horizontal'		=> __DIR__ . '/../view/partial/form/horizontal.phtml',
			'mail/layout/text'		=> __DIR__ . '/../view/mail/layout/text.phtml',
			'mail/layout/html'		=> __DIR__ . '/../view/mail/layout/html.phtml',
			'pagination'			=> __DIR__ . '/../view/partial/pagination.phtml',
			'tabulate/tabulate'		=> __DIR__ . '/../view/partial/tabulate.phtml',
			'tabulate/quantum'		=> __DIR__ . '/../view/partial/tabulate/quantum.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
