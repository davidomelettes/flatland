<?php

namespace FlatlandGameTest\Controller;

use FlatlandGame\Controller\GamesController;
use FlatlandGameTest\Bootstrap;
use Zend\Http\Request,
	Zend\Http\Response,
	Zend\Mvc\MvcEvent,
	Zend\Mvc\Router\RouteMatch,
	Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter,
	Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class GamesControllerTest extends AbstractHttpControllerTestCase
{
	protected function setUp()
	{
		$this->setApplicationConfig(
			include __DIR__ . '/../../../../../config/application.config.php'
		);
		parent::setUp();
	}
	
	public function testIndexActionCanBeAccessed()
	{
		$this->dispatch('/games');
		$this->assertResponseStatusCode(200);
		
		$this->assertModuleName('FlatlandGame');
		$this->assertControllerName('Game\Controller\Games');
		$this->assertControllerClass('GamesController');
		$this->assertMatchedRouteName('games');
	}
	
}
