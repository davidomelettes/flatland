<?php

namespace FlatlandAdmin\Form;

use OmelettesSignup\Form\SignupFilter;

class AddUserFilter extends SignupFilter
{
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = parent::getInputFilter();
			$factory = $inputFilter->getFactory();
			
			$this->inputFilter = $inputFilter;
		}
		
		return $inputFilter;
	}
	
}
