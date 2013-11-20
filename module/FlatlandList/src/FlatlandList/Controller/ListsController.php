<?php

namespace FlatlandList\Controller;

use Omelettes\Controller\QuantumController;

class ListsController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandList\Form\AddTopListFilter';
	
	protected $addQuantumFormClass = 'FlatlandList\Form\AddTopListForm';
	
	protected $editQuantumFilterClass = 'FlatlandList\Form\AddTopListFilter';
	
	protected $editQuantumFormClass = 'FlatlandList\Form\AddTopListForm';
	
	protected $quantumMapperClass = 'FlatlandList\Model\TopListsMapper';
	
	protected $quantumModelClass = 'FlatlandList\Model\TopList';
	
}
