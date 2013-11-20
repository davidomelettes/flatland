<?php

namespace FlatlandAdmin\Model;

use FlatlandGame\Model\Game as GameGame;

class Game extends GameGame
{
	public function getTableHeadings()
	{
		$headings = parent::getTableHeadings();
		$headings = array_merge($headings, array(
			'actions' => '',
		));
		
		return $headings;
	}
	
	public function getTableRowPartial()
	{
		return 'tabulate/admin-game';
	}
	
}
