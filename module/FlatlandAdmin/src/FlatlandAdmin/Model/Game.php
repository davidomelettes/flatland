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
	
	public function getTableHeadings()
	{
		$headings = parent::getTableHeadings();
		$headings['actions'] = '';
		
		return $headings;
	}
	
	public function getTableRowPartial()
	{
		return 'tabulate/admin-game';
	}
	
}
