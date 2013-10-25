<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration001Users extends AbstractMigration
{
	public function migrate()
	{
		if ($this->tableHasColumn('users', 'name_reset_name')) {
			// Skip this migration
			$this->logger->debug('Migration has already been run; skipping');
			return true;
		}
		
		$this->tableAddColumns('users', array(
			'name_reset_name'			=> 'VARCHAR',
			'name_reset_key'			=> 'UUID',
			'name_reset_requested'		=> 'TIMESTAMP',
			'password_reset_key'		=> 'UUID',
			'password_reset_requested'	=> 'TIMESTAMP',
		));
		
		$this->insertFixture('migration_next/fixtures/001_users.xml');
		
		$this->tableCreate('user_logins', array(
			'name'		=> 'VARCHAR NOT NULL REFERENCES users(name)',
			'series'	=> 'UUID NOT NULL',
			'token'		=> 'UUID NOT NULL',
			'created'	=> 'TIMESTAMP NOT NULL DEFAULT now()',
		), array('name', 'series', 'token'));
		
		return true;
	}
	
}
