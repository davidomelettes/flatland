<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\QuantumForm;

class AddGameForm extends QuantumForm
{
	public function __construct($name = 'form-add-game')
	{
		parent::__construct($name);
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
			'name'		=> 'publisher_key',
			'type'		=> 'Autocomplete',
			'options'	=> array(
				'label'			=> 'Publisher',
				'source'		=> 'admin/publishers',
				'source_options'=> array('action' => 'autocomplete'),
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Publisher',
			),
		));
		
		$this->addSubmitFieldset();
	}
	
}
