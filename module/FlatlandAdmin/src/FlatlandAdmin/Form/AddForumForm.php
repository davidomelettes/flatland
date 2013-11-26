<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\QuantumForm;

class AddForumForm extends QuantumForm
{
	public function __construct($name = 'form-add-forum')
	{
		parent::__construct($name);
	}
	
	public function init()
	{
		$this->addNameElement('Name');
		
		$this->addSubmitFieldset();
	}
	
}
