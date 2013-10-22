<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumModel;
use Zend\Validator\Date as DateValidator;

class GameVariant extends QuantumModel
{
	protected $propertyMap = array(
		'game'			=> 'game_key',
		'language'		=> 'language',
		'edition'		=> 'edition',
		'description'	=> 'description',
		'releaseDate'	=> 'release_date',
		'publisher'		=> 'publisher_key',
	);
	
	protected $game;
	protected $language;
	protected $edition;
	protected $description;
	protected $releaseDate;
	protected $publisher;
	
}
