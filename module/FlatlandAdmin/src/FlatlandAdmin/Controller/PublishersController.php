<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form,
	FlatlandAdmin\Model;
use Omelettes\Controller\QuantumController;

class PublishersController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandAdmin\Form\AddPublisherFilter';
	
	protected $addQuantumFormClass = 'FlatlandAdmin\Form\AddPublisherForm';
	
	protected $editQuantumFilterClass = 'FlatlandAdmin\Form\AddPublisherFilter';
	
	protected $editQuantumFormClass = 'FlatlandAdmin\Form\AddPublisherForm';
	
	protected $quantumMapperClass = 'FlatlandAdmin\Model\PublishersMapper';

	protected $quantumModelClass = 'FlatlandAdmin\Model\Publisher';
	
}
