<?php

namespace FlatlandGame\Controller;

use FlatlandGame\Model;
use FlatlandForum\Model as ForumModel;

class GameForumController extends GamesController
{
	protected $addQuantumFilterClass = 'FlatlandForum\Form\AddThreadFilter';
	
	protected $addQuantumFormClass = 'FlatlandForum\Form\AddThreadForm';
	
	/**
	 * @var ForumModel\ThreadsMapper
	 */
	protected $threadsMapper;
	
	/**
	 * @var ForumModel\PostsMapper
	 */
	protected $postsMapper;
	
	public function getForumsMapper()
	{
		if (!$this->forumsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandForum\Model\ForumsMapper');
			$this->forumsMapper = $mapper;
		}
	
		return $this->forumsMapper;
	}
	
	public function getThreadsMapper()
	{
		if (!$this->threadsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandGame\Model\ThreadsMapper');
			$this->threadsMapper = $mapper;
		}
	
		return $this->threadsMapper;
	}
	
	public function getPostsMapper()
	{
		if (!$this->postsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandForum\Model\PostsMapper');
			$this->postsMapper = $mapper;
		}
	
		return $this->postsMapper;
	}
	
	public function getGameForumNavigationConfig(Model\Game $model)
	{
		return array(
			array(
				'label'			=> 'New Topic',
				'route'			=> 'games/game/forum/new-topic',
				'routeOptions'	=> array('slug' => $model->slug),
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
			'crud'		=> $this->constructNavigation($this->getGameForumNavigationConfig($game)),
			'modelNav'	=> $this->constructNavigation($this->getGameNavigationConfig($game)),
			'paginator' => $this->getThreadsMapper()->fetchForGame($game, true),
		));
	}
	
	public function addAction()
	{
		$game = $this->findRequestedModel();
		if (!$game) {
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		$thread = new ForumModel\Thread();
		$form = $this->getAddQuantumForm();
		$form->bind($thread);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($this->getAddQuantumFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$post = $thread->post;
				
				$this->getQuantumMapper()->beginTransaction();
				try {
					$thread->gameKey = $game->key;
					$this->getThreadsMapper()->createQuantum($thread);
					$post->threadKey = $thread->key;
					$this->getPostsMapper()->createQuantum($post);
					
					$this->getQuantumMapper()->commitTransaction();
					$this->flashMessenger()->addSuccessMessage('Topic created');
					return $this->redirect()->toRoute('games/game/forum/topic', array('slug' => $game->slug));
					
				} catch (\Exception $e) {
					$this->getQuantumMapper()->rollbackTransaction();
					$this->flashMessenger()->addErrorMessage('There was a problem creating your topic');
					throw $e;
				}
			}
		}
		
		return $this->returnViewModel( array(
			'model'		=> $game,
			'crud'		=> $this->constructNavigation($this->getGameForumNavigationConfig($game)),
			'modelNav'	=> $this->constructNavigation($this->getGameNavigationConfig($game)),
			'form'		=> $form,
		));
	}
	
	public function viewAction()
	{
		$game = $this->findRequestedModel();
		if (!$game) {
			return $this->redirect()->toRoute('games');
		}
		
		$thread = $this->getThreadsMapper()->find($this->params('topic_key'));
		if (!$thread) {
			$this->flashMessenger()->addErrorMessage('Failed to find thread with key: ' . $this->params('topic_key'));
			return $this->redirect()->toRoute('games');
		}
		
		return $this->returnViewModel( array(
			'model'		=> $game,
			'crud'		=> $this->constructNavigation($this->getGameForumNavigationConfig($game)),
			'modelNav'	=> $this->constructNavigation($this->getGameNavigationConfig($game)),
			'paginator' => $this->getPostsMapper()->fetchForThread($thread, true),
		));
	}
	
}
