<?php

namespace FlatlandList\Model;

use FlatlandGame\Model\Game;

class ListItem extends Game
{
	protected $gameKey;
	
	protected $listKey;
	
	protected $listOrder;
	
	protected $propertyMap = array(
		'gameKey'		=> 'game_key',
		'listKey'		=> 'list_key',
		'listOrder'		=> 'list_order',
	);
	
}
