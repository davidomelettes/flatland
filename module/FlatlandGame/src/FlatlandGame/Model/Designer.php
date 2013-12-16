<?php

namespace FlatlandGame\Model;

use Omelettes\Model\QuantumModel;

class Designer extends QuantumModel
{
	protected $slug;
	
	protected $propertyMap = array(
		'slug' => 'slug',
	);
	
}
