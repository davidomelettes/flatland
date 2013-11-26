<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\QuantumForm;

class AddForumForm extends QuantumForm
{
	public function __construct($name = 'form-add-forum')
	{
		parent::__construct($name);
	}
	
	public function init()
	{
		$this->addNameElement('Name');
		
		$forumsMapper = $this->getApplicationServiceLocator()->get('FlatlandAdmin\Model\ForumsMapper');
		$parentOptions = array('' => '-- None --');
		foreach ($forumsMapper->fetchAll() as $parent) {
			$parentOptions[$parent->key] = $parent->name;
		}
		$this->add(array(
			'name'		=> 'parent_key',
			'type'		=> 'Select',
			'options'	=> array(
				'label'		=> 'Parent Forum',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Parent',
				'options'	=> $parentOptions,
			),
		));
		
		$this->addSubmitFieldset();
	}
	
}
