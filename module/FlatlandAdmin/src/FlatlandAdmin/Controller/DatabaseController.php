<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form,
	FlatlandAdmin\Model\Game,
	FlatlandAdmin\Model\GamesMapper;
use Omelettes\Controller\AbstractController;
use FlatlandAdmin\Form\AddGameFilter;

class DatabaseController extends AbstractController
{
	/**
	 * @var Form\AddGameFilter
	 */
	protected $addGameFilter;
	
	/**
	 * @var Form\AddGameForm
	 */
	protected $addGameForm;
	
	/**
	 * @var GamesMapper
	 */
	protected $gamesMapper;

	public function getAddGameFilter()
	{
		if (!$this->addGameFilter) {
			$filter = $this->getServiceLocator()->get('FlatlandAdmin\Form\AddGameFilter');
			$this->addGameFilter = $filter;
		}
		
		return $this->addGameFilter;
	}
	
	public function getAddGameForm()
	{
		if (!$this->addGameForm) {
			$form = $this->getServiceLocator()->get('FormElementManager')->get('FlatlandAdmin\Form\AddGameForm');
			$this->addGameForm = $form;
		}
	
		return $this->addGameForm;
	}
	
	public function getGamesMapper()
	{
		if (!$this->gamesMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandAdmin\Model\GamesMapper');
			$this->gamesMapper = $mapper;
		}
		
		return $this->gamesMapper;
	}
	
	public function addGameAction()
	{
		$form = $this->getAddGameForm();
		
		$request = $this->getRequest();
		$game = new Game();
		$form->bind($game);
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getAddGameFilter()->getInputFilter());
			$form->setData($request->getPost());
				
			if ($form->isValid()) {
				$this->getGamesMapper()->addGame($game);
			}
		}
		
		return array(
			'form' => $form,
		);
	}
	
	public function indexAction()
	{
		$games = $this->getGamesMapper()->fetchAll(true);
		
		return array(
			'games' => $games,
		);
	}
	
}
