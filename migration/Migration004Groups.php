<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration004Groups extends AbstractMigration
{
	public function migrate()
	{
		$this->tableCreate('groups', array_merge($this->getQuantumTableColumns(), array(
			'private'				=> "BOOLEAN NOT NULL DEFAULT 'true'",
		)));
		
		$this->tableCreate('group_users', array(
			'group_key'				=> "UUID NOT NULL REFERENCES groups(key)",
			'user_key'				=> "UUID NOT NULL REFERENCES users(key)",
		), array('group_key', 'user_key'));
		
		$this->tableCreate('user_libraries', array(
			'user_key'				=> "UUID NOT NULL REFERENCES users(key)",
			'game_key'				=> "UUID NOT NULL REFERENCES games(key)",
		));
		
		return true;
	}
	
}
