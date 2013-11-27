<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration003Games extends AbstractMigration
{
	public function migrate()
	{
		$this->quantumTableCreateWithView('publishers');
		
		$this->quantumTableCreateWithView('designers');
		
		$this->quantumTableCreateWithView('games');
		
		$this->insertFixture('migration/fixtures/003_games.xml');
		
		return true;
	}
	
}
