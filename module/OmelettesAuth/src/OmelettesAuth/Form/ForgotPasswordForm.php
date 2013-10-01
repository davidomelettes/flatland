<?php

namespace OmelettesAuth\Form;

use Omelettes\Form\AbstractQuantumForm;

class ForgotPasswordForm extends AbstractQuantumForm
{
	public function __construct($name = null)
	{
		parent::__construct('form-forgot-password');
		
		$this->addNameElement('Email Address');
		$this->get('name')->setAttribute('placeholder', 'Email Address');
		
		$this->addSubmitElement('Reset password');
	}
	
}