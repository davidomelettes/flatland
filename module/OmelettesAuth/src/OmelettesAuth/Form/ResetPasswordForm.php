<?php

namespace OmelettesAuth\Form;

use Omelettes\Form\AbstractQuantumForm;

class ResetPasswordForm extends AbstractQuantumForm
{
	public function __construct($name = null)
	{
		parent::__construct('form-reset-password');
		
		$this->add(array(
			'name'		=> 'password_new',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'New Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'NewPassword',
				'placeholder'	=> 'New Password',
				'autocomplete'	=> 'off',
			),
		));
		$this->add(array(
			'name'		=> 'password_verify',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Verify Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'VerifyPassword',
				'placeholder'	=> 'Verify Password',
				'autocomplete'	=> 'off',
			),
		));
		
		$this->addSubmitFieldset('Change Password');
	}
	
}