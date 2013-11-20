<?php

namespace FlatlandAdmin\Form;

use OmelettesSignup\Form\SignupForm;

class AddUserForm extends SignupForm
{
	public function __construct($name = 'form-add-user')
	{
		parent::__construct($name);
	}
	
	public function init()
	{
		$this->get('name')->setAttribute('placeholder', null);
		$this->get('full_name')->setAttribute('placeholder', null);
		$this->get('password')->setAttribute('placeholder', null);
		$this->get('submit')->get('submit')->setValue('Save');
		
		$this->remove('invitation_code');
	}
	
}
