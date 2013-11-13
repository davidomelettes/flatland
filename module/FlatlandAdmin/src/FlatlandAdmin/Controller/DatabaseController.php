<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form,
	FlatlandAdmin\Model\Game,
	FlatlandAdmin\Model\GamesMapper;
use Omelettes\Controller\AbstractController;

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
	
	public function addAction()
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
		$paginator = $this->getGamesMapper()->fetchAll(true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		
		return array(
			'games' => $paginator,
		);
	}
	
	public function viewAction()
	{
		$game = $this->getGamesMapper()->find($this->params('key'));
		if (!$game) {
			$this->flashMessenger()->addErrorMessage('Failed to find game with key: ' . $this->params('key'));
			return $this->redirect()->toRoute('admin/database');
		}
		
		return array(
			'game' => $game,
		);
	}
	
	public function deleteAction()
	{
		$game = $this->getGamesMapper()->find($this->params('key'));
		if (!$game) {
			$this->flashMessenger()->addErrorMessage('Failed to find game with key: ' . $this->params('key'));
			return $this->redirect()->toRoute('admin/database');
		}
		
		$form = $this->getConfirmDeleteForm($game, 'admin/database', array('action' => 'view', 'key' => $game->key));
		$request = $this->getRequest();
		if ($request->isPost()) {
			$this->getGamesMapper()->deleteGame($game);
			$this->flashMessenger()->addSuccessMessage($game->name . ' deleted');
			return $this->redirect()->toRoute('admin/database');
		}
		
		return array(
			'game' => $game,
			'form' => $form,
		);
	}
	
}
