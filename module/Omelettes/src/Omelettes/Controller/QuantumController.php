<?php

namespace Omelettes\Controller;

use Omelettes\Form,
	Omelettes\Model;
use Zend\View\Model\JsonModel;

abstract class QuantumController extends AbstractController
{
	/**
	 * @var Form\AbstractQuantumForm
	 */
	protected $addQuantumForm;
	
	protected $addQuantumFormClass;
	
	/**
	 * @var Form\AbstractQuantumFilter
	 */
	protected $addQuantumFilter;
	
	protected $addQuantumFilterClass;
	
	/**
	 * @var Form\AbstractQuantumForm
	 */
	protected $editQuantumForm;
	
	protected $editQuantumFormClass;
	
	/**
	 * @var Form\AbstractQuantumFilter
	 */
	protected $editQuantumFilter;
	
	protected $editQuantumFilterClass;
	
	/**
	 * @var Form\ConfirmDeleteForm
	 */
	protected $deleteQuantumForm;
	
	/**
	 * @var Model\QuantumMapper
	 */
	protected $quantumMapper;
	
	protected $quantumMapperClass;
	
	/**
	 * @var Model\QuantumModel
	 */
	protected $quantumModel;
	
	protected $quantumModelClass;
	
	/**
	 * @return QuantumMapper
	 */
	public function getQuantumMapper()
	{
		if (!$this->quantumMapperClass) {
			throw new \Exception('quantumMapperClass must be defined');
		}
		if (!$this->quantumMapper) {
			$mapper = $this->getServiceLocator()->get($this->quantumMapperClass);
			$this->quantumMapper = $mapper;
		}
		
		return $this->quantumMapper;
	}
	
	/**
	 * @return QuantumModel
	 */
	public function getQuantumModel()
	{
		if (!$this->quantumModelClass) {
			throw new \Exception('quantumModelClass must be defined');
		}
		
		if (!$this->quantumModel) {
			$model = new $this->quantumModelClass;
			$this->quantumModel = $model;
		}
		
		return $this->quantumModel;
	}
	
	public function getAddQuantumForm()
	{
		if (!$this->addQuantumFormClass) {
			throw new \Exception('addQuantumFormClass must be defined');
		}
		if (!$this->addQuantumForm) {
			$form = $this->getServiceLocator()->get('FormElementManager')->get($this->addQuantumFormClass);
			$this->addQuantumForm = $form;
		}
		
		return $this->addQuantumForm;
	}
	
	public function getAddQuantumFilter()
	{
		if (!$this->addQuantumFilterClass) {
			throw new \Exception('addQuantumFilterClass must be defined');
		}
		if (!$this->addQuantumFilter) {
			$filter = $this->getServiceLocator()->get($this->addQuantumFilterClass);
			$this->addQuantumFilter = $filter;
		}
		
		return $this->addQuantumFilter;
	}
	
	public function getEditQuantumForm()
	{
		if (!$this->editQuantumFormClass) {
			throw new \Exception('editQuantumFormClass must be defined');
		}
		if (!$this->editQuantumForm) {
			$form = $this->getServiceLocator()->get('FormElementManager')->get($this->editQuantumFormClass);
			$this->editQuantumForm = $form;
		}
		
		return $this->editQuantumForm;
	}
	
	public function getEditQuantumFilter()
	{
		if (!$this->editQuantumFilterClass) {
			throw new \Exception('editQuantumFilterClass must be defined');
		}
		if (!$this->editQuantumFilter) {
			$filter = $this->getServiceLocator()->get($this->editQuantumFilterClass);
			$this->editQuantumFilter = $filter;
		}
		
		return $this->editQuantumFilter;
	}
	
	public function getDeleteQuantumForm($model = null, $route = null, $routeOptions = array())
	{
		if (!$this->deleteQuantumForm) {
			$form = new Form\ConfirmDeleteForm();
			if ($model instanceof Model\QuantumModel) {
				$submitFieldset = $form->get('submit');
				$submitFieldset->add(array(
					'name'		=> 'cancel',
					'type'		=> 'Omelettes\Form\Element\Url',
					'attributes'=> array(
						'value'		=> 'Cancel',
					),
					'options' => array(
						'route' => $route,
						'route_options' => $routeOptions,
						'anchor_class' => 'btn btn-default',
					),
				));
			}
			$this->deleteQuantumForm = $form;
		}
	
		return $this->deleteQuantumForm;
	}
	
	public function addAction()
	{
		$model = $this->getQuantumModel();
		$form = $this->getAddQuantumForm();
		$form->bind($model);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($this->getAddQuantumFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$this->getQuantumMapper()->createQuantum($model);
				$this->flashMessenger()->addSuccessMessage('Record created');
				return $this->redirect()->toRoute($this->getRouteName(), array('action' => 'view', 'key' => $model->key));
			}
		}
		
		return $this->returnViewModel(array(
			'form' => $form,
		));
	}
	
	public function viewAction()
	{
		$model = $this->getQuantumMapper()->find($this->params('key'));
		if (!$model) {
			$this->flashMessenger()->addErrorMessage('Failed to find record with key: ' . $this->params('key'));
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		return $this->returnViewModel(array(
			'model' => $model,
		));
	}
	
	public function indexAction()
	{
		$paginator = $this->getQuantumMapper()->fetchAll(true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		
		return $this->returnViewModel(array(
			'paginator' => $paginator,
		));
	}
	
	public function editAction()
	{
		$key = $this->params('key');
		$model = $this->getQuantumMapper()->find($key);
		if (!$model) {
			$this->flashMessenger()->addErrorMessage('Failed to find record with key: ' . $this->params('key'));
			return $this->redirect()->toRoute($this->getRouteName());
		}
		$form = $this->getEditQuantumForm();
		$form->bind($model);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($this->getEditQuantumFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				// Model has been hydrated, no non-form properties will be set
				$model->key = $key;
				$this->getQuantumMapper()->updateQuantum($model);
				$this->flashMessenger()->addSuccessMessage('Record updated');
				return $this->redirect()->toRoute($this->getRouteName(), array('action' => 'view', 'key' => $model->key));
			}
		}
		
		return $this->returnViewModel(array(
			'form' => $form,
			'model' => $model,
		));
	}
	
	public function deleteAction()
	{
		$model = $this->getQuantumMapper()->find($this->params('key'));
		if (!$model) {
			$this->flashMessenger()->addErrorMessage('Failed to find record with key: ' . $this->params('key'));
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		$form = $this->getDeleteQuantumForm($model, $this->getRouteName(), array('action' => 'view', 'key' => $model->key));
		$request = $this->getRequest();
		if ($request->isPost()) {
			$this->getQuantumMapper()->deleteQuantum($model);
			$this->flashMessenger()->addSuccessMessage($model->name . ' deleted');
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		return $this->returnViewModel(array(
			'model' => $model,
			'form' => $form,
		));
	}
	
	public function autocompleteAction()
	{
		$viewModel = $this->returnViewModel();
		if (!$viewModel instanceof JsonModel) {
			$this->flashMessenger()->addErrorMessage('Accept: application/json only');
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		$term = $this->params()->fromQuery('term', '');
		$paginator = $this->getQuantumMapper()->fetchAllWhereNameLike($term, true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		
		$results = array();
		foreach ($paginator as $quantum) {
			$results[] = array(
				'label' => $quantum->name,
				'value' => $quantum->key,
			);
		}
		if (empty($results)) {
			$results[] = array(
				'label' => sprintf("No Results for '%s'", $term),
				'value' => '',
			);
		}
		$viewModel->setVariables($results);
		
		return $viewModel;
	}
	
}
