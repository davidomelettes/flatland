<?php

namespace FlatlandGame\Controller;

use Omelettes\Controller\QuantumController;

class GamesController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandGame\Form\AddGameFilter';
	
	protected $addQuantumFormClass = 'FlatlandGame\Form\AddGameForm';
	
	protected $editQuantumFilterClass = 'FlatlandGame\Form\AddGameFilter';
	
	protected $editQuantumFormClass = 'FlatlandGame\Form\AddGameForm';
	
	protected $quantumMapperClass = 'FlatlandGame\Model\GamesMapper';
	
	protected $quantumModelClass = 'FlatlandGame\Model\Game';
	
}
