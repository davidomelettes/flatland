<?php

namespace FlatlandTrading\Controller;

use FlatlandTrading\Form,
	FlatlandTrading\Model;
use Omelettes\Controller\QuantumController;

class TradesController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandTrading\Form\AddTradeFilter';
	
	protected $addQuantumFormClass = 'FlatlandTrading\Form\AddTradeForm';
	
	protected $editQuantumFilterClass = 'FlatlandTrading\Form\AddTradeFilter';
	
	protected $editQuantumFormClass = 'FlatlandTrading\Form\AddTradeForm';
	
	protected $quantumMapperClass = 'FlatlandTrading\Model\TradesMapper';

	protected $quantumModelClass = 'FlatlandTrading\Model\Trade';
	
}
