<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration004Groups extends AbstractMigration
{
	public function migrate()
	{
		$this->quantumTableCreateWithView('groups');
		
		$this->tableCreate('group_users', array(
			'group_key' => 'UUID NOT NULL REFERENCES groups(key)',
			'user_key' => 'UUID NOT NULL REFERENCES games(key)',
		), array('group_key', 'user_key'));
		
		$this->quantumTableCreateWithView('events', array(
			'group_key' => 'UUID NOT NULL REFERENCES groups(key)',
			'start'		=> 'TIMESTAMP WITH TIME ZONE',
		));
		
		return true;
	}
	
}
