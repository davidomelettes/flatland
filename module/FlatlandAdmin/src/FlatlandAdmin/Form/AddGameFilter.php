<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\AbstractQuantumModelFilter;

class AddGameFilter extends AbstractQuantumModelFilter
{
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = $this->getDefaultInputFilter();
			$factory = $inputFilter->getFactory();
			
			$variantFilter = $this->getServiceLocator()->get('FlatlandAdmin\Form\GameVariantFilter');
			$inputFilter->add($variantFilter->getInputFilter(), 'variant');
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
