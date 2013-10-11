<?php

namespace FlatlandGame\Form;

use Omelettes\Form\AbstractQuantumForm;

class GameForm extends AbstractQuantumForm
{
	public function __construct()
	{
		parent::__construct('form-game');
	}
	
	public function init()
	{
		$this->add(array(
			'name'		=> 'language',
			'type'		=> 'Select',
			'options'	=> array(
				'label'		=> 'Language',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Language',
			),
		));
		
		$this->add(array(
			'name'		=> 'edition',
			'type'		=> 'Select',
			'options'	=> array(
				'label'		=> 'Edition',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Edition',
			),
		));
		
		$this->addNameElement();
		
		$this->add(array(
			'name'		=> 'description',
			'type'		=> 'Textarea',
			'options'	=> array(
				'label'		=> 'Description',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Description',
			),
		));
		
		$this->addSubmitElement();
	}
	
}
