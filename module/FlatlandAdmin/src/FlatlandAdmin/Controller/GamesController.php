<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form,
	FlatlandAdmin\Model;
use Omelettes\Controller\QuantumController;

class GamesController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandAdmin\Form\AddGameFilter';
	
	protected $addQuantumFormClass = 'FlatlandAdmin\Form\AddGameForm';
	
	protected $editQuantumFilterClass = 'FlatlandAdmin\Form\AddGameFilter';
	
	protected $editQuantumFormClass = 'FlatlandAdmin\Form\AddGameForm';
	
	protected $quantumMapperClass = 'FlatlandAdmin\Model\GamesMapper';

	protected $quantumModelClass = 'FlatlandAdmin\Model\Game';
	
}
