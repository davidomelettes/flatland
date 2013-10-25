<?php

namespace OmelettesConsole\Controller;

use OmelettesMigration;
use Omelettes\Controller\AbstractController;
use OmelettesConsole\Migration;
use Zend\Console\Request as ConsoleRequest,
	Zend\Mvc\Controller\AbstractActionController;

class MigrationController extends AbstractController
{
	protected $migrationPath = 'migration_next/';
	protected $migrationFilePattern = '/^(Migration(\d{3}).+)\.php$/';
	protected $migrationFiles;
	
	protected $dbName;
	
	protected function scanMigrationDirectory()
	{
		$migrationPathFiles = scandir($this->migrationPath);
		$migrationFiles = array();
		foreach ($migrationPathFiles as $file) {
			if (preg_match($this->migrationFilePattern, $file, $m)) {
				// Remove leading zeroes
				$fileSequence = preg_replace('/^0+/', '', $m[2]);
				$migrationFiles[$fileSequence] = $m[1];
			}
		}
		$this->migrationFiles = $migrationFiles;
	}

	protected function getMigrationFile($sequenceNumber)
	{
		if (!is_array($this->migrationFiles)) {
			$this->scanMigrationDirectory();
		}
		
		$sequenceNumber = preg_replace('/^0+/', '', $sequenceNumber);
		if (isset($this->migrationFiles[$sequenceNumber])) {
			return "OmelettesMigration\\".$this->migrationFiles[$sequenceNumber];
		}
		
		return false;
	}
	
	public function getMigration($sequenceNumber)
	{
		$migrationClass = $this->getMigrationFile($sequenceNumber);
		if (!$migrationClass) {
			throw new \Exception('No migration found for sequence number: ' . $sequenceNumber);
		}
		
		$migration = new $migrationClass(
			$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
			$this->getServiceLocator()->get('Logger')
		);
		
		return $migration;
	}
	
	public function migrateAction()
	{
		$this->getLogger()->info('Migration Action');
		$request = $this->getRequest();
		if ($request->getParam('test')) {
			$this->logger->info('TEST MODE: Transaction will not be committed');
		}
		
		$sequenceNumber = $request->getParam('sequence');
		$migration = $this->getMigration($sequenceNumber);
		$this->getLogger()->debug("Running migration $sequenceNumber: " . get_class($migration));
		$migration->beginTransaction();
		try {
			$migration->migrate();
		} catch (\Exception $e) {
			$migration->rollbackTransaction();
			$this->logger->warn("Exception occurred during migration $sequenceNumber: " . $e->getMessage());
			throw $e;
		}
		if (!$request->getParam('test')) {
			$migration->commitTransaction();
		}
		
		$this->logger->info('Action complete');
	}
	
}
