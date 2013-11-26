<?php

namespace OmelettesAuth\Form;

use Omelettes\Form\QuantumForm;

class LoginForm extends QuantumForm
{
	public function __construct()
	{
		parent::__construct('form-login');
		
		$this->addNameElement('Email Address');
		$this->get('name')->setAttribute('placeholder', 'Email Address');
		
		$this->add(array(
			'name'		=> 'password',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Password',
				'placeholder'	=> 'Password',
			),
		));
		$this->add(array(
			'name'		=> 'remember_me',
			'type'		=> 'Checkbox',
			'options'	=> array(
				'label'		=> 'Keep me signed in?',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'RememberMe',
			),
		));
		
		$this->addSubmitFieldset('Sign in', 'btn btn-lg btn-block btn-primary');
	}
	
}