<?php

namespace FlatlandForum\Form;

use Omelettes\Form\QuantumForm;

class ReplyForm extends QuantumForm
{
	public function __construct($name = 'form-reply')
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
