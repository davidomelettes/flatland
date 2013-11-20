<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration008Groups extends AbstractMigration
{
	public function migrate()
	{
		$this->tableCreate('groups', array_merge($this->getQuantumTableColumns(), array(
		)));
		
		$this->tableCreate('group_users', array_merge(array(
			'group_key' => 'UUID NOT NULL REFERENCES lists(key)',
			'user_key' => 'UUID NOT NULL REFERENCES games(key)',
		)), array('group_key', 'user_key'));
		
		return true;
	}
	
}
