<?php

namespace OmelettesUser\Form;

use Omelettes\Form\AbstractQuantumForm;

class ChangePasswordForm extends AbstractQuantumForm
{
	public function __construct()
	{
		parent::__construct('form-change-password');
		
		$this->add(array(
			'name'		=> 'password_old',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Current password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'OldPassword',
				'autocomplete'	=> 'off',
			),
		));
		$this->add(array(
			'name'		=> 'password_new',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'New Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'NewPassword',
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
				'autocomplete'	=> 'off',
			),
		));
		
		$this->addSubmitFieldset('Change Password');
	}
	
}
