<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration004Lists extends AbstractMigration
{
	public function migrate()
	{
		$this->quantumTableCreateWithView('lists', array(
			'public'	=> "BOOLEAN NOT NULL DEFAULT 'true'",
		));
		
		$this->tableCreate('list_items', array_merge(array(
			'list_key'		=> 'UUID NOT NULL REFERENCES lists(key)',
			'game_key'		=> 'UUID NOT NULL REFERENCES games(key)',
			'list_order'	=> "INT NOT NULL DEFAULT '0'",
		)), array('list_key', 'game_key'));
		$this->viewCreate('list_items_view',
			"SELECT games_view.*, list_items.list_key, list_items.list_order FROM games_view LEFT JOIN list_items ON list_items.game_key = games_view.key");
		
		return true;
	}
	
}
