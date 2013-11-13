<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\AbstractQuantumModelFilter;

class AddGameFilter extends AbstractQuantumModelFilter
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
