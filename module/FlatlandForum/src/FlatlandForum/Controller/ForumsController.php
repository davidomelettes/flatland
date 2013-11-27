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
		$model = $this->getQuantumMapper()->findBySlug($this->params('slug'));
		if (!$model) {
			$this->flashMessenger()->addErrorMessage('Failed to find record with slug: ' . $this->params('slug'));
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		return $this->returnViewModel(array(
			'model'		=> $model,
			'crud'		=> $this->constructNavigation($this->getViewNavigationConfig($model)),
			'paginator'	=> $this->getThreadsMapper()->fetchAll(true),
		));
	}
	
}
