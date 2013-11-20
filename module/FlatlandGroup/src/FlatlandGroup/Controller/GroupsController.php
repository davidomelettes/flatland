<?php

namespace FlatlandGroup\Controller;

use Omelettes\Controller\QuantumController;

class GroupsController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandGroup\Form\AddGroupFilter';
	
	protected $addQuantumFormClass = 'FlatlandGroup\Form\AddGroupForm';
	
	protected $editQuantumFilterClass = 'FlatlandGroup\Form\AddGroupFilter';
	
	protected $editQuantumFormClass = 'FlatlandGroup\Form\AddGroupForm';
	
	protected $quantumMapperClass = 'FlatlandGroup\Model\GroupsMapper';
	
	protected $quantumModelClass = 'FlatlandGroup\Model\Group';
	
}
