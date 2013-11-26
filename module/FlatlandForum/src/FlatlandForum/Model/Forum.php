<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumModel;

class Forum extends QuantumModel
{
	protected $parentKey;
	
	protected $slug;
	
	protected $propertyMap = array(
		'parentKey'	=> 'parent_key',
		'slug'		=> 'slug',
	);
	
}
