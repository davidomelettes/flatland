<?php

namespace FlatlandGame\Model;

use Omelettes\Model\QuantumModel;

class Publisher extends QuantumModel
{
	protected $slug;
	
	protected $propertyMap = array(
		'slug' => 'slug',
	);
	
}
