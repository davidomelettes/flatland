<?php

namespace FlatlandForum\Form;

use Omelettes\Form\QuantumForm;

class AddThreadForm extends QuantumForm
{
	public function __construct($name = 'form-add-thread')
	{
		parent::__construct($name);
	}
	
	public function init()
	{
		$this->addNameElement('Title');
		
		$postFieldset = new PostFieldset();
		$this->add($postFieldset);
		
		$this->addSubmitFieldset('Submit New Topic');
	}
	
}
