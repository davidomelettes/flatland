<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration003Games extends AbstractMigration
{
	public function migrate()
	{
		$this->quantumTableCreateWithView('publishers', array(
			'slug'			=> 'VARCHAR',
		));
		
		$this->quantumTableCreateWithView('designers', array(
			'slug'			=> 'VARCHAR',
		));
		
		$this->quantumTableCreateWithView('games', array(
			'slug'			=> 'VARCHAR',
		));
		
		$this->insertFixture('migration/fixtures/003_games.xml');
		
		return true;
	}
	
}
