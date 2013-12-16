<?php

namespace FlatlandGame\Controller;

use FlatlandGame\Model;
use Omelettes\Controller\QuantumController;

class GamesController extends QuantumController
{
	protected $addQuantumFilterClass = '';
	
	protected $addQuantumFormClass = '';
	
	protected $editQuantumFilterClass = '';
	
	protected $editQuantumFormClass = '';
	
	protected $quantumMapperClass = 'FlatlandGame\Model\GamesMapper';
	
	protected $quantumModelClass = 'FlatlandGame\Model\Game';
	
	public function getGameNavigationConfig(Model\Game $model)
	{
		$routeOptions = $model->slug ? array('slug' => $model->slug) : array('key' => $model->key);
		$config = array(
			array(
				'label'			=> 'Info',
				'route'			=> 'games/game',
				'routeOptions'	=> $routeOptions,
			),
			array(
				'label'			=> 'Forum',
				'route'			=> 'games/game/forum',
				'routeOptions'	=> $routeOptions,
			),
			array(
				'label'			=> 'Lists',
				'route'			=> 'games/game/lists',
				'routeOptions'	=> $routeOptions,
			),
		);
		return $config;
	}
	
	public function viewAction()
	{
		$game = $this->findRequestedModel();
		if (!$game) {
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		return $this->returnViewModel( array(
			'model'		=> $game,
			'crud'		=> $this->constructNavigation($this->getViewNavigationConfig($game)),
			'modelNav'	=> $this->constructNavigation($this->getGameNavigationConfig($game)),
		));
	}
	
}
