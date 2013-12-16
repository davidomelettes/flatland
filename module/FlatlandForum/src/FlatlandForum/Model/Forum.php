<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumModel;

class Forum extends QuantumModel
{
	protected $slug;
	
	protected $parentKey;
	
	protected $propertyMap = array(
		'slug'		=> 'slug',
		'parentKey'	=> 'parent_key',
	);
	
	public function getTableRowPartial()
	{
		return 'tabulate/forum';
	}
	
}
