<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration003Games extends AbstractMigration
{
	public function migrate()
	{
		if ($this->tableExists('games')) {
			// Skip this migration
			$this->logger->debug('Migration has already been run; skipping');
			return true;
		}
		
		return true;
		$this->tableCreate('games', array(
			
		));
		
		return true;
	}
	
}
