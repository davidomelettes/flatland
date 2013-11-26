<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\QuantumFilter;

class AddForumFilter extends QuantumFilter
{
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = parent::getInputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'parent_key',
				'required'		=> false,
				'filters'		=> array(
				),
				'validators'	=> array(
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
