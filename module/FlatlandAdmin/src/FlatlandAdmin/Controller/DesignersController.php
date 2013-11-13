<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form,
	FlatlandAdmin\Model;
use Omelettes\Controller\QuantumController;

class DesignersController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandAdmin\Form\AddDesignerFilter';
	
	protected $addQuantumFormClass = 'FlatlandAdmin\Form\AddDesignerForm';
	
	protected $editQuantumFilterClass = 'FlatlandAdmin\Form\AddDesignerFilter';
	
	protected $editQuantumFormClass = 'FlatlandAdmin\Form\AddDesignerForm';
	
	protected $quantumMapperClass = 'FlatlandAdmin\Model\DesignersMapper';

	protected $quantumModelClass = 'FlatlandAdmin\Model\Designer';
	
}
