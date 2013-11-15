<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumModel;

class Game extends QuantumModel
{
	protected $description;
	
	protected $publisherKey;
	
	protected $publisher;
	
	protected $propertyMap = array(
		'description'	=> 'description',
		'publisherKey'	=> 'publisher_key',
		'publisher'		=> 'publisher',
	);
	
}
