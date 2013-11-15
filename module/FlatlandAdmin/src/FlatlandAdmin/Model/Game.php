<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumModel;

class Game extends QuantumModel
{
	protected $publisherKey;
	
	protected $propertyMap = array(
		'publisherKey' => 'publisher_key',
	);
	
}
