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
		$variantFieldset = $this->getApplicationServiceLocator()->get('FormElementManager')->get('FlatlandAdmin\Form\GameVariantFieldset');
		$variantFieldset->setName('variant');
		$this->add($variantFieldset);
		
		$this->addSubmitElement();
	}
	
}
