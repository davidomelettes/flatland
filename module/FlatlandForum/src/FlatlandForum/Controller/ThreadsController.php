<?php

namespace FlatlandForum\Controller;

use Omelettes\Controller\QuantumController,
	Omelettes\Model\QuantumModel;

class ThreadsController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandForum\Form\AddThreadFilter';
	
	protected $addQuantumFormClass = 'FlatlandForum\Form\AddThreadForum';
	
	protected $editQuantumFilterClass = '';
	
	protected $editQuantumFormClass = '';
	
	protected $quantumMapperClass = 'FlatlandForum\Model\ThreadsMapper';
	
	protected $quantumModelClass = 'FlatlandForum\Model\Thread';
	
	/**
	 * @var Model\ForumsMapper
	 */
	protected $forumsMapper;
	
	public function getForumsMapper()
	{
		if (!$this->forumsMapper) {
			$mapper = $this->getServiceLocator()->get('FlatlandForum\Model\ForumsMapper');
			$this->forumsMapper = $mapper;
		}
		
		return $this->forumsMapper;
	}
	
}
