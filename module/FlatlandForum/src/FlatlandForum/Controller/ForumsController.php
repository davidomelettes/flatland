<?php

namespace FlatlandForum\Controller;

use Omelettes\Controller\QuantumController;

class ForumsController extends QuantumController
{
	protected $addQuantumFilterClass = '';
	
	protected $addQuantumFormClass = '';
	
	protected $editQuantumFilterClass = '';
	
	protected $editQuantumFormClass = '';
	
	protected $quantumMapperClass = 'FlatlandForum\Model\ForumsMapper';
	
	protected $quantumModelClass = 'FlatlandForum\Model\Forum';
	
}
