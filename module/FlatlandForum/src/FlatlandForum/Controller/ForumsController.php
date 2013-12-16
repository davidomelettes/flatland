<?php

namespace FlatlandForum\Controller;

use Omelettes\Controller\QuantumController,
	Omelettes\Model\QuantumModel;

class ForumsController extends QuantumController
{
	protected $addQuantumFilterClass = '';
	
	protected $addQuantumFormClass = '';
	
	protected $editQuantumFilterClass = '';
	
	protected $editQuantumFormClass = '';
	
	protected $quantumMapperClass = 'FlatlandForum\Model\ForumsMapper';
	
	protected $quantumModelClass = 'FlatlandForum\Model\Forum';
	
	/**
	 * @var Model\ThreadsMapper
	 */
	protected $threadsMapper;
	
	public function getThreadsMapper()
	{
		if (!$this->threadsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandForum\Model\ThreadsMapper');
			$this->threadsMapper = $mapper;
		}
		
		return $this->threadsMapper;
	}
	
	public function getViewNavigationConfig(QuantumModel $model)
	{
		return array(
			array(
				'label'			=> 'New Topic',
				'route'			=> 'threads',
				'routeOptions'	=> array('action' => 'add', 'key' => $model->key),
				'icon'			=> 'plus',
			),
		);
	}
	
	public function viewAction()
	{
		$forum = $this->findRequestedModel();
		if (!$forum) {
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		return $this->returnViewModel(array(
			'model'		=> $forum,
			'crud'		=> $this->constructNavigation($this->getViewNavigationConfig($forum)),
			'paginator'	=> $this->getThreadsMapper()->fetchForForum($forum, true),
		));
	}
	
}
