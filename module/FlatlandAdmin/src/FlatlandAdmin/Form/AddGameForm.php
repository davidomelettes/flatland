<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\QuantumForm;

class AddGameForm extends QuantumForm
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
