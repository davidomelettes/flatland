<?php

namespace OmelettesMigration;

use Omelettes\Migration\AbstractMigration;

class Migration002Locales extends AbstractMigration
{
	public function migrate()
	{
		if ($this->tableExists('locale_countries')) {
			// Skip this migration
			$this->logger->debug('Migration has already been run; skipping');
			return true;
		}
		if (!$this->tableExists('')) {
			
		}
		
		$this->tableCreate('locale_countries', array(
			'code'		=> 'CHAR(2) PRIMARY KEY',
			'name'		=> 'VARCHAR NOT NULL',
			'native'	=> 'VARCHAR NOT NULL'
		));
		
		$this->tableCreate('locale_languages', array(
			'code'		=> 'CHAR(2) PRIMARY KEY',
			'name'		=> 'VARCHAR NOT NULL',
			'native'	=> 'VARCHAR NOT NULL'
		));
		
		$this->tableCreate('locale_currencies', array(
			'code'					=> 'CHAR(3) PRIMARY KEY',
			'name'					=> 'VARCHAR NOT NULL',
			'symbol'				=> 'CHAR(1)',
			'symbol_prefix'			=> 'BOOLEAN NOT NULL DEFAULT true',
			'decimals'				=> 'INT NOT NULL',
			'decimal_separator'		=> 'CHAR(1) NOT NULL',
			'thousands_separator'	=> 'CHAR(1) NOT NULL',
		));
		
		$this->tableCreate('locale_date_formats', array(
			'code'			=> 'CHAR(3) PRIMARY KEY',
			'format'		=> 'VARCHAR NOT NULL',
			'php_format'	=> 'VARCHAR NOT NULL'
		));
		
		$this->tableCreate('locales', array(
			'code'			=> 'VARCHAR PRIMARY KEY',
			'country_code'	=> 'CHAR(2) NOT NULL REFERENCES locale_countries(code)',
			'language_code'	=> 'CHAR(2) NOT NULL REFERENCES locale_languages(code)',
			'currency_code'	=> 'CHAR(3) NOT NULL REFERENCES locale_currencies(code)',
			'date_code'		=> 'CHAR(3) NOT NULL REFERENCES locale_date_formats(code)',
		));
		
		$this->insertFixture('migration_next/fixtures/002_locales.xml');

		$this->viewCreate('locales_view', "SELECT locales.*, locale_countries.name as country_name, locale_countries.native as country_native, locale_languages.name as language_name, locale_languages.native as language_native, locale_currencies.name as currency_name, locale_currencies.symbol as currency_symbol, locale_currencies.decimals as currency_decimals, locale_currencies.decimal_separator as currency_decimal_separator, locale_currencies.thousands_separator as currency_thousands_separator, locale_date_formats.format as date_format, locale_date_formats.php_format as date_php_format, locale_languages.name || ' (' || locale_countries.name || ')' as name, locale_languages.native || ' (' || locale_countries.native || ')' as native
			FROM locales
			LEFT JOIN locale_countries ON locales.country_code = locale_countries.code
			LEFT JOIN locale_languages ON locales.language_code = locale_languages.code
			LEFT JOIN locale_currencies ON locales.currency_code = locale_currencies.code
			LEFT JOIN locale_date_formats ON locales.date_code = locale_date_formats.code"
		);
		
		$this->tableAddColumns('users', array(
			'locale'	=> "VARCHAR NOT NULL REFERENCES locales(code) DEFAULT 'en_GB'",
		));
		
		$this->tableCreate('user_secondary_locales', array(
			'user_key'		=> 'UUID NOT NULL REFERENCES users(key)',
			'locale_code'	=> 'VARCHAR NOT NULL REFERENCES locales(code)',
		), array('user_key', 'locale_code'));
		
		$this->viewCreate('user_locales_view', "SELECT user_secondary_locales.user_key, locales_view.*
			FROM user_secondary_locales
			LEFT JOIN locales_view ON locales_view.code = user_secondary_locales.locale_code"
		);
		
		$this->ruleCreate(
			'user_locales_insert',
			'INSERT',
			'user_locales_view',
			"INSERT INTO user_secondary_locales (user_key, locale_code) VALUES (NEW.user_key, NEW.code)"
		);
		
		$this->ruleCreate(
			'user_locales_delete',
			'DELETE',
			'user_locales_view',
			"DELETE FROM user_secondary_locales WHERE user_key = OLD.user_key AND locale_code = OLD.code"
		);
		
		return true;
	}
	
}
