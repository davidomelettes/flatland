<?php

namespace FlatlandGame\Controller;

use Omelettes\Controller\AbstractController;

class GamesController extends AbstractController
{
	public function indexAction()
	{
		$paginator = $this->getGamesMapper()->fetchAll(true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		
		return array(
			'games' => $paginator,
		);
	}
	
	public function viewAction()
	{
		return array();
	}
	
}
