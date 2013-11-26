<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form,
	FlatlandAdmin\Model;
use Omelettes\Controller\QuantumController;

class ForumsController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandAdmin\Form\AddForumFilter';
	
	protected $addQuantumFormClass = 'FlatlandAdmin\Form\AddForumForm';
	
	protected $editQuantumFilterClass = 'FlatlandAdmin\Form\AddForumFilter';
	
	protected $editQuantumFormClass = 'FlatlandAdmin\Form\AddForumForm';
	
	protected $quantumMapperClass = 'FlatlandAdmin\Model\ForumsMapper';

	protected $quantumModelClass = 'FlatlandAdmin\Model\Forum';
	
}
