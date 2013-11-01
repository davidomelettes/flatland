<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration001Users extends AbstractMigration
{
	public function migrate()
	{
		$this->tableAddColumns('users', array(
			'name_reset_name'			=> 'VARCHAR',
			'name_reset_key'			=> 'UUID',
			'name_reset_requested'		=> 'TIMESTAMP',
			'password_reset_key'		=> 'UUID',
			'password_reset_requested'	=> 'TIMESTAMP',
		));
		
		$this->insertFixture('migration/fixtures/001_users.xml');
		
		$this->tableCreate('sessions', array(
			'id'		=> 'CHAR(32) NOT NULL',
			'name'		=> 'CHAR(32) NOT NULL',
			'modified'	=> 'INT NOT NULL',
			'lifetime'	=> 'INT NOT NULL',
			'data'		=> 'TEXT',
		), array('id', 'name'));
		
		$this->tableCreate('user_logins', array(
			'name'		=> 'VARCHAR NOT NULL REFERENCES users(name)',
			'series'	=> 'UUID NOT NULL',
			'token'		=> 'UUID NOT NULL',
			'created'	=> 'TIMESTAMP NOT NULL DEFAULT now()',
		), array('name', 'series', 'token'));
		
		return true;
	}
	
}
