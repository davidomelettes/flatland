<?php

namespace FlatlandGroup\Controller;

use FlatlandGroup\Model;
use FlatlandMember\Model\MembersMapper;
use Omelettes\Controller\QuantumController;

class GroupsController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandGroup\Form\AddGroupFilter';
	
	protected $addQuantumFormClass = 'FlatlandGroup\Form\AddGroupForm';
	
	protected $editQuantumFilterClass = 'FlatlandGroup\Form\AddGroupFilter';
	
	protected $editQuantumFormClass = 'FlatlandGroup\Form\AddGroupForm';
	
	protected $quantumMapperClass = 'FlatlandGroup\Model\GroupsMapper';
	
	protected $quantumModelClass = 'FlatlandGroup\Model\Group';
	
	/**
	 * @var MembersMapper
	 */
	protected $groupMembersMapper;
	
	/**
	 * @var Model\EventsMapper
	 */
	protected $groupEventsMapper;
	
	public function getGroupMembersMapper()
	{
		if (!$this->groupMembersMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandMember\Model\MembersMapper');
			$this->groupMembersMapper = $mapper;
		}
		
		return $this->groupMembersMapper;
	}
	
	public function getGroupEventsMapper()
	{
		if (!$this->groupEventsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandGroup\Model\EventsMapper');
			$this->groupEventsMapper = $mapper;
		}
	
		return $this->groupEventsMapper;
	}
	
	public function indexAction()
	{
		return $this->returnViewModel(array(
			'paginator'	=> $this->getQuantumPaginator(),
			'crud'		=> $this->constructNavigation($this->getIndexNavigationConfig()),
			'events'	=> $this->getGroupEventsMapper()->fetchAll(true),
		));
	}
	
	public function viewAction()
	{
		$group = $this->findRequestedModel();
		if (!$group) {
			return $this->redirect()->toRoute($this->getRouteName());
		}
		
		return $this->returnViewModel(array(
			'model' 	=> $group,
			'crud'		=> $this->constructNavigation($this->getViewNavigationConfig($group)),
			'members'	=> $this->getGroupMembersMapper()->fetchAll(true),
			'events'	=> $this->getGroupEventsMapper()->fetchAll(true),
		));
	}
	
}
