<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration003Games extends AbstractMigration
{
	public function migrate()
	{
		$this->tableCreate('publishers', $this->getQuantumTableColumns());
		
		$this->tableCreate('designers', $this->getQuantumTableColumns());
		
		$this->tableCreate('games', $this->getQuantumTableColumns());
		
		$this->tableCreate('game_locale_details', array(
			'game_key'				=> 'UUID NOT NULL REFERENCES games(key)',
			'language_code'			=> 'CHAR(2) NOT NULL REFERENCES locale_languages(code)',
			'name'					=> 'VARCHAR',
			'description'			=> 'TEXT',
		), array('game_key', 'language_code'));
		
		$this->tableCreate('game_designers', array(
			'game_key'				=> 'UUID NOT NULL REFERENCES games(key)',
			'designer_key'			=> 'UUID NOT NULL REFERENCES designers(key)',
		), array('game_key', 'designer_key'));
		
		$this->tableCreate('game_products', array_merge($this->getQuantumTableColumns(), array(
			'game_key'				=> 'UUID NOT NULL REFERENCES games(key)',
			'publisher_key'			=> 'UUID REFERENCES publishers(key)',
			'published'				=> 'DATE',
			'published_precision'	=> "INT NOT NULL DEFAULT '1'",
			'edition'				=> "INT NOT NULL DEFAULT '1'",
		)));
		
		$this->tableCreate('game_product_languages', array(
			'product_key'			=> 'UUID NOT NULL REFERENCES game_products(key)',
			'language_code'			=> 'CHAR(2) NOT NULL REFERENCES locale_languages(code)',
		), array('product_key', 'language_code'));
		
		$this->insertFixture('migration/fixtures/003_games.xml');
		
		return true;
	}
	
}
