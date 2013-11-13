<?php

namespace Omelettes\Form;

class ConfirmDeleteForm extends AbstractQuantumForm
{
	public function __construct($name = 'confirm-delete')
	{
		parent::__construct($name);
		
		$this->addSubmitElement('Delete');
	}
	
}
