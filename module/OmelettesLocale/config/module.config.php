<?php

return array(
	'controllers' => array(
		'invokables' => array(
		),
	),
	'filters' => array(
		'invokables' => array(
			'LocaleDate' => 'OmelettesLocale\Validator\LocaleDate',
		),
	),
	'router' => array(
		'routes' => array(
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
