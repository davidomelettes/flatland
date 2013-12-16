<?php

namespace FlatlandList\Controller;

use FlatlandList\Form,
	FlatlandList\Model;
use Omelettes\Controller\QuantumController;

class ListsController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandList\Form\AddTopListFilter';
	
	protected $addQuantumFormClass = 'FlatlandList\Form\AddTopListForm';
	
	protected $editQuantumFilterClass = 'FlatlandList\Form\AddTopListFilter';
	
	protected $editQuantumFormClass = 'FlatlandList\Form\AddTopListForm';
	
	protected $quantumMapperClass = 'FlatlandList\Model\TopListsMapper';
	
	protected $quantumModelClass = 'FlatlandList\Model\TopList';
	
	/**
	 * @var Model\ListItemsMapper
	 */
	protected $listItemsMapper;
	
	/**
	 * @var Form\AddListItemForm
	 */
	protected $addListItemForm;
	
	/**
	 * @var Form\AddListItemFilter
	 */
	protected $addListItemFilter;
	
	public function getAddListItemForm()
	{
		if (!$this->addListItemForm) {
			$form = $this->getServiceLocator()->get('FormElementManager')->get('FlatlandList\Form\AddListItemForm');
			$this->addListItemForm = $form;
		}
		
		return $this->addListItemForm;
	}
	
	public function getAddListItemFilter()
	{
		if (!$this->addListItemFilter) {
			$filter = $this->getServiceLocator()->get('FlatlandList\Form\AddListItemFilter');
			$this->addListItemFilter = $filter;
		}
	
		return $this->addListItemFilter;
	}
	
	public function getListItemsMapper()
	{
		if (!$this->listItemsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandList\Model\ListItemsMapper');
			$this->listItemsMapper = $mapper;
		}
		
		return $this->listItemsMapper;
	}
	
	public function viewAction()
	{
		$list = $this->findRequestedModel();
		if (!$list) {
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		return $this->returnViewModel( array(
			'model'		=> $list,
			'crud'		=> $this->constructNavigation($this->getViewNavigationConfig($list)),
			'listItems'	=> $this->getListItemsMapper()->fetchForList($list, true),
		));
	}
	
	public function getViewNavigationConfig(Model\TopList $model)
	{
		$config = parent::getViewNavigationConfig($model);
		array_unshift($config, array(
			'label'			=> 'Add Item',
			'route'			=> $this->getRouteName(),
			'routeOptions'	=> array('action' => 'add-item', 'key' => $model->key),
			'icon'			=> 'plus',
		));
		
		return $config;
	}
	
	public function addItemAction()
	{
		$list = $this->findRequestedModel();
		if (!$list) {
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		$listItem = new Model\ListItem();
		$form = $this->getAddListItemForm();
		$form->bind($listItem);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($this->getAddListItemFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$listItem->listKey = $list->key;
				$this->getListItemsMapper()->createQuantum($listItem);
				$this->flashMessenger()->addSuccessMessage('Item added');
				return $this->redirect()->toRoute($this->getRouteName(), array('action' => 'view', 'key' => $list->key));
			}
		}
		
		return $this->returnViewModel( array(
			'model'		=> $list,
			'form'		=> $form,
		));
	}
	
}
