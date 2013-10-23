<?php

namespace OmelettesConsole\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class MigrationController extends AbstractActionController
{
	public function helloAction()
	{
		$this->flashMessenger()->addErrorMessage('This is a bad thing');
		$this->flashMessenger()->addSuccessMessage('Good things happen to good people');
		$request = $this->getRequest();
		if (!$request instanceof ConsoleRequest) {
			throw new \Exception('This action must be run from a console');
		}
		
		return "hello world!\n";
	}
	
}
