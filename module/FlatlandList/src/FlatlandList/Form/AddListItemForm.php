<?php

namespace FlatlandList\Form;

use Omelettes\Form\QuantumForm;

class AddListItemForm extends QuantumForm
{
	public function __construct()
	{
		parent::__construct('form-add-list-item');
	}
	
	public function init()
	{
		$this->add(array(
			'name'		=> 'game_key',
			'type'		=> 'Autocomplete',
			'options'	=> array(
				'label'			=> 'Game Title',
				'source'		=> 'games',
				'source_options'	=> array('action' => 'autocomplete'),
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'GameKey',
			),
		));
		
		$this->addSubmitFieldset('Save');
	}
	
}
