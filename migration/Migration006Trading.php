<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration006Trading extends AbstractMigration
{
	public function migrate()
	{
		$this->tableCreate('trades', array_merge($this->getQuantumTableColumns(), array(
		)));
		
		return true;
	}
	
}
