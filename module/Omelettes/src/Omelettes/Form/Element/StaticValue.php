<?php

namespace Omelettes\Form\Element;

use Zend\Form\Element;

class StaticValue extends Element
{
	protected $attributes = array(
		'type' => 'static',
	);
}
