<?php

namespace FlatlandForum\Form;

use Omelettes\Form\QuantumForm;

class AddThreadForm extends QuantumForm
{
	public function __construct($name = 'form-add-post')
	{
		parent::__construct($name);
	}
	
	public function init()
	{
		$postFieldset = new PostFieldset();
		$this->add($postFieldset);
		
		$this->addSubmitFieldset('Reply');
	}
	
}
