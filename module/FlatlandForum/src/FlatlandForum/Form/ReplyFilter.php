<?php

namespace FlatlandForum\Form;

use Omelettes\Form\QuantumFilter;

class ReplyFilter extends QuantumFilter
{
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = $this->getDefaultInputFilter();
			$factory = $inputFilter->getFactory();
			
			$postFilter = $this->getServiceLocator()->get('FlatlandForum\Form\PostFieldsetFilter');
			$inputFilter->add($postFilter->getInputFilter(), 'post');
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
