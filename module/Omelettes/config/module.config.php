<?php

return array(
	'acl' => array(
		'resources' => array(
		),
	),
	'controllers' => array(
		'invokables' => array(
		),
	),
	'filters' => array(
		'invokables' => array(
			'Slug' => 'Omelettes\Filter\Slug',
		),
	),
	'form_elements' => array(
		'invokables' => array(
			'autocomplete' => 'Omelettes\Form\Element\Autocomplete',
			'staticValue' => 'Omelettes\Form\Element\StaticValue',
		),
	),
	'navigation' => array(
		'default' => array(),
	),
	'router' => array(
		'routes' => array(
		),
	),
	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'aliases' => array(
			'translator' => 'MvcTranslator',
		),
		'factories' => array(
			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
		),
	),
	'translator' => array(
		'locale'					=> 'en_GB',
		'translation_file_patterns' => array(
			array(
				'type'		=> 'gettext',
				'base_dir'	=> __DIR__ . '/../language',
				'pattern'	=> '%s.mo',
			),
		),
	),
	'validators' => array(
		'invokables' => array(
			'Password' => 'Omelettes\Validator\Password',
		),
	),
	'view_helpers'	=> array(
		'invokables'	=> array(
			'tabulate'		=> 'Omelettes\View\Helper\Tabulate',
			'prettyText'	=> 'Omelettes\View\Helper\PrettyText',
			'prettyTime'	=> 'Omelettes\View\Helper\PrettyTime',
			'prettyUser'	=> 'Omelettes\View\Helper\PrettyUser',
			'prettyUuid'	=> 'Omelettes\View\Helper\PrettyUuid',
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'flash-messenger'		=> __DIR__ . '/../view/partial/flash-messenger.phtml',
			'form/friendly'			=> __DIR__ . '/../view/partial/form/friendly.phtml',
			'form/horizontal'		=> __DIR__ . '/../view/partial/form/horizontal.phtml',
			'form/inline'			=> __DIR__ . '/../view/partial/form/inline.phtml',
			'mail/layout/text'		=> __DIR__ . '/../view/mail/layout/text.phtml',
			'mail/layout/html'		=> __DIR__ . '/../view/mail/layout/html.phtml',
			'nav/buttons'			=> __DIR__ . '/../view/partial/navigation/buttons.phtml',
			'nav/navbar'			=> __DIR__ . '/../view/partial/navigation/navbar.phtml',
			'nav/pills'				=> __DIR__ . '/../view/partial/navigation/pills.phtml',
			'pagination'			=> __DIR__ . '/../view/partial/pagination.phtml',
			'page-title'			=> __DIR__ . '/../view/partial/page-title.phtml',
			'pretty/user'			=> __DIR__ . '/../view/partial/pretty/user.phtml',
			'tabulate/tabulate'		=> __DIR__ . '/../view/partial/tabulate.phtml',
			'tabulate/quantum'		=> __DIR__ . '/../view/partial/tabulate/quantum.phtml',
			'info/authorship'		=> __DIR__ . '/../view/partial/info/authorship.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
