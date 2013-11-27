<?php

namespace FlatlandForum\Controller;

use FlatlandForum\Form,
	FlatlandForum\Model;
use Omelettes\Controller\QuantumController,
	Omelettes\Model\QuantumModel;

class ThreadsController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandForum\Form\AddThreadFilter';
	
	protected $addQuantumFormClass = 'FlatlandForum\Form\AddThreadForm';
	
	protected $editQuantumFilterClass = '';
	
	protected $editQuantumFormClass = '';
	
	protected $quantumMapperClass = 'FlatlandForum\Model\ThreadsMapper';
	
	protected $quantumModelClass = 'FlatlandForum\Model\Thread';
	
	/**
	 * @var Model\ForumsMapper
	 */
	protected $forumsMapper;
	
	/**
	 * @var Model\PostsMapper
	 */
	protected $postsMapper;
	
	/**
	 * @var Form\ReplyForm
	 */
	protected $replyForm;
	
	/**
	 * @var Form\ReplyFilter
	 */
	protected $replyFilter;
	
	public function getForumsMapper()
	{
		if (!$this->forumsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandForum\Model\ForumsMapper');
			$this->forumsMapper = $mapper;
		}
		
		return $this->forumsMapper;
	}
	
	public function getPostsMapper()
	{
		if (!$this->postsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandForum\Model\PostsMapper');
			$this->postsMapper = $mapper;
		}
	
		return $this->postsMapper;
	}
	
	public function getReplyForm()
	{
		if (!$this->replyForm) {
			$form = $this->getServiceLocator()->get('FormElementManager')->get('FlatlandForum\Form\ReplyForm');
			$this->replyForm = $form;
		}
		
		return $this->replyForm;
	}
	
	public function getReplyFilter()
	{
		if (!$this->replyFilter) {
			$filter = $this->getServiceLocator()->get('FlatlandForum\Form\ReplyFilter');
			$this->replyFilter = $filter;
		}
		
		return $this->replyFilter;
	}
	
	public function addAction()
	{
		if ($this->getQuantumMapper()->isReadOnly()) {
			$this->flashMessenger()->addErrorMessage('You do not have permission to do that');
			return $this->redirect()->toRoute($this->getRouteName());
		}
		$forum = $this->getForumsMapper()->find($this->params('key'));
		if (!$forum) {
			$this->flashMessenger()->addErrorMessage('Unable to find forum');
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		$model = $this->getQuantumModel();
		$form = $this->getAddQuantumForm();
		$form->bind($model);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($this->getAddQuantumFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$post = $model->post;
				
				$this->getQuantumMapper()->beginTransaction();
				try {
					$this->getQuantumMapper()->createQuantum($model);
					$post->threadKey = $model->key;
					$this->getPostsMapper()->createQuantum($post);
					
					$this->getQuantumMapper()->commitTransaction();
					$this->flashMessenger()->addSuccessMessage('Topic created');
					return $this->redirect()->toRoute($this->getRouteName(), array('action' => 'view', 'key' => $model->key));
					
				} catch (\Exception $e) {
					$this->getQuantumMapper()->rollbackTransaction();
					$this->flashMessenger()->addErrorMessage('There was a problem creating your topic');
					throw $e;
				}
			}
		}
		
		return $this->returnViewModel(array(
			'form'	=> $form,
			'forum'	=> $forum,
		));
	}
	
	public function viewAction()
	{
		$thread = $this->getQuantumMapper()->find($this->params('key'));
		if (!$thread) {
			$this->flashMessenger()->addErrorMessage('Failed to find thread with key: ' . $this->params('key'));
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		$post = new Model\Post();
		$form = $this->getReplyForm();
		$form->bind($post);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($this->getReplyFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$post->threadKey = $thread->key;
				$this->getPostsMapper()->createQuantum($post);
				$this->flashMessenger()->addSuccessMessage('Post successful');
				return $this->redirect()->toRoute($this->getRouteName(), array('action' => 'view', 'key' => $thread->key));
			}
		}
		
		return $this->returnViewModel( array(
			'model'		=> $thread,
			'crud'		=> $this->constructNavigation($this->getViewNavigationConfig($thread)),
			'paginator'	=> $this->getPostsMapper()->fetchForThread($thread, true),
			'form'		=> $form,
		));
	}
	
}