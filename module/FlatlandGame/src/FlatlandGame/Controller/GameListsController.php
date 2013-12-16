<?php

namespace FlatlandGame\Controller;

use FlatlandGame\Model as Model;
use FlatlandList\Model as ListModel;

class GameListsController extends GamesController
{
	/**
	 * @var ListModel\ListsMapper
	 */
	protected $listsMapper;
	
	public function getListsMapper()
	{
		if (!$this->listsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandList\Model\TopListsMapper');
			$this->listsMapper = $mapper;
		}
	
		return $this->listsMapper;
	}
	
	public function getGameListsNavigationConfig(Model\Game $model)
	{
		return array(
			array(
				'label'			=> 'New List',
				'route'			=> 'lists',
				'routeOptions'	=> array('action' => 'add'),
				'icon'			=> 'plus',
			),
		);
	}
	
	public function indexAction()
	{
		$game = $this->findRequestedModel();
		if (!$game) {
			return $this->redirect()->toRoute($this->getRouteName());
		}
	
		return $this->returnViewModel( array(
			'model'		=> $game,
			'crud'		=> $this->constructNavigation($this->getGameListsNavigationConfig($game)),
			'modelNav'	=> $this->constructNavigation($this->getGameNavigationConfig($game)),
			'paginator' => $this->getListsMapper()->fetchForGame($game, true),
		));
	}
	
}
