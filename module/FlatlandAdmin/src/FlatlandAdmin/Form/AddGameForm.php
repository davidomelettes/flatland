<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\QuantumForm;

class AddGameForm extends QuantumForm
{
	public function __construct($name = 'form-add-game')
	{
		parent::__construct($name);
	}
	
	public function init()
	{
		$this->addNameElement('Name');
		
		$this->addSubmitFieldset();
	}
	
}
