<?php

namespace Stub\Controller;

use Omelettes\Controller\QuantumController;

class StubController extends QuantumController
{
	protected $addQuantumFilterClass = 'Stub\Form\AddStubbyFilter';
	
	protected $addQuantumFormClass = 'Stub\Form\AddStubbyForm';
	
	protected $editQuantumFilterClass = 'Stub\Form\AddStubbyFilter';
	
	protected $editQuantumFormClass = 'Stub\Form\AddStubbyForm';
	
	protected $quantumMapperClass = 'Stub\Model\StubbyMapper';
	
	protected $quantumModelClass = 'Stub\Model\Stubby';
	
}
