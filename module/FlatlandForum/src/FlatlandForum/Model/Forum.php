<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumModel;

class Forum extends QuantumModel
{
	protected $slug;
	
	protected $propertyMap = array(
		'slug' => 'slug',
	);
	
}
