<?php

namespace FlatlandMember\Controller;

use Omelettes\Controller\QuantumController;

class MembersController extends QuantumController
{
	protected $addQuantumFilterClass = '';
	
	protected $addQuantumFormClass = '';
	
	protected $editQuantumFilterClass = '';
	
	protected $editQuantumFormClass = '';
	
	protected $quantumMapperClass = 'FlatlandMember\Model\MembersMapper';
	
	protected $quantumModelClass = 'OmelettesAuth\Model\User';
	
}
