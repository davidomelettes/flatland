<?php

namespace OmelettesSignup\Form;

use Omelettes\Form\QuantumForm;

class SignupForm extends QuantumForm
{
	public function __construct($name = 'form-signup')
	{
		parent::__construct($name);
		
		$this->addNameElement('Email Address');
		$this->get('name')->setAttribute('placeholder', 'Email Address');
		
		$this->add(array(
			'name'		=> 'full_name',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Full Name',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'FullName',
				'autocomplete'	=> 'off',
				'placeholder'	=> 'Full Name',
			),
		));
		
		$this->add(array(
			'name'		=> 'password',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Password',
				'autocomplete'	=> 'off',
				'placeholder'	=> 'Password',
			),
		));
		
		$this->add(array(
			'name'		=> 'invitation_code',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Invitation Code',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'InvitationCode',
				'autocomplete'	=> 'off',
				'placeholder'	=> 'Invitation Code',
			),
		));
		
		$this->addSubmitFieldset('Sign up for free', 'btn btn-lg btn-block btn-warning');
	}
	
}