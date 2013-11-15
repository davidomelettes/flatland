<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration003Games extends AbstractMigration
{
	public function migrate()
	{
		$this->tableCreate('publishers', $this->getQuantumTableColumns());
		
		$this->tableCreate('designers', $this->getQuantumTableColumns());
		
		$this->tableCreate('games', array_merge($this->getQuantumTableColumns(), array(
			'description'			=> 'TEXT',
			'publisher_key'			=> "UUID REFERENCES publishers(key)", 
		)));
		
		$this->tableCreate('game_designers', array(
			'game_key'				=> 'UUID NOT NULL REFERENCES games(key)',
			'designer_key'			=> 'UUID NOT NULL REFERENCES designers(key)',
		), array('game_key', 'designer_key'));
		
		$this->insertFixture('migration/fixtures/003_games.xml');
		
		$this->viewCreate('games_view', "SELECT games.*, publishers.name as publisher FROM games LEFT JOIN publishers ON publishers.key = games.publisher_key");
		
		return true;
	}
	
}
