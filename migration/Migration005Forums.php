<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration005Forums extends AbstractMigration
{
	public function migrate()
	{
		$this->quantumTableCreateWithView('forums', array(
			'slug'			=> 'VARCHAR',
			'parent_key'	=> 'UUID REFERENCES forums(key)',
		));
		
		$this->quantumTableCreateWithView('threads', array(
			'slug'			=> 'VARCHAR',
			'forum_key'		=> 'UUID REFERENCES forums(key)',
			'game_key'		=> 'UUID REFERENCES games(key)',
		));
		
		$this->quantumTableCreateWithView('posts', array(
			'content'			=> "TEXT NOT NULL",
			'format'			=> "VARCHAR NOT NULL DEFAULT 'text'",
			'locale_code'		=> "VARCHAR NOT NULL DEFAULT 'en_GB'",
			'thread_key'		=> 'UUID NOT NULL REFERENCES threads(key)',
		));
		
		$this->insertFixture('migration/fixtures/005_forums.xml');
		
		return true;
	}
	
}
