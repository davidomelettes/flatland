<?php

namespace FlatlandGame\Model;

use Omelettes\Model\QuantumModel;

class Game extends QuantumModel
{
	protected $slug;
	
	protected $propertyMap = array(
		'slug' => 'slug',
	);
	
	public function getTableHeadings()
	{
		$headings = parent::getTableHeadings();
		$headings = array_merge($headings, array());
	
		return $headings;
	}
	
	public function getTableRowPartial()
	{
		return 'tabulate/game';
	}
	
}
