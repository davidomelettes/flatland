<?php

namespace FlatlandForum\Form;

use Omelettes\Form\QuantumFilter;

class AddThreadFilter extends QuantumFilter
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
