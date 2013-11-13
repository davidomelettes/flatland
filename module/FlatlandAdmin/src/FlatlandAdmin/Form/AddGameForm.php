<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\AbstractQuantumForm;

class AddGameForm extends AbstractQuantumForm
{
	public function __construct()
	{
		parent::__construct('form-add-game');
	}
	
	public function init()
	{
		$this->addNameElement('Name');
		
		$this->add(array(
			'name'		=> 'description',
			'type'		=> 'Textarea',
			'options'	=> array(
				'label'		=> 'Description',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Description',
			),
		));
		
		$this->add(array(
			'name'		=> 'publisher',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Publisher',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Publisher',
			),
		));
		
		$this->addSubmitFieldset();
	}
	
}
