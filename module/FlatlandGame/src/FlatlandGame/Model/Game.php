<?php

namespace FlatlandGame\Model;

use Omelettes\Model\QuantumModel;

class Game extends QuantumModel
{
	protected $description;
	
	protected $propertyMap = array(
		'description' => 'description',
	);
	
}
