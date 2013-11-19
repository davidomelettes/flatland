<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration005Forums extends AbstractMigration
{
	public function migrate()
	{
		$this->tableCreate('forums', array_merge($this->getQuantumTableColumns(), array(
			'parent_key' => 'UUID REFERENCES forums(key)',
		)));
		
		$this->tableCreate('threads', array_merge($this->getQuantumTableColumns(), array(
			'forum_key' => 'UUID REFERENCES forums(key)',
		)));
		
		$this->tableCreate('comments', array_merge($this->getQuantumTableColumns(), array(
			'thread_key' => 'UUID NOT NULL REFERENCES threads(key)',
		)));
		
		$this->insertFixture('migration/fixtures/005_forums.xml');
		
		return true;
	}
	
}
