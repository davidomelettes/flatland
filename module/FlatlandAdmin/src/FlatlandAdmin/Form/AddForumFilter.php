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
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
