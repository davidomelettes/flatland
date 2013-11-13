<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\AbstractQuantumForm;

class InviteUserForm extends AbstractQuantumForm
{
	public function __construct($name = 'form-invite-user')
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
		
		$this->addSubmitFieldset('Invite');
	}
	
}
