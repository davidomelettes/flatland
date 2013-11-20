<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration007Lists extends AbstractMigration
{
	public function migrate()
	{
		$this->tableCreate('lists', array_merge($this->getQuantumTableColumns(), array(
		)));
		
		$this->tableCreate('list_games', array_merge(array(
			'list_key' => 'UUID NOT NULL REFERENCES lists(key)',
			'game_key' => 'UUID NOT NULL REFERENCES games(key)',
		)), array('list_key', 'game_key'));
		
		return true;
	}
	
}
