<?php

namespace FlatlandGroup\Model;

use Omelettes\Model\QuantumModel;

class Group extends QuantumModel
{
	protected $slug;
	
	protected $propertyMap = array(
		'slug'	=> 'slug',
	);
	
}
