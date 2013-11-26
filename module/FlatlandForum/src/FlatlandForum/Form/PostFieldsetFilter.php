<?php

namespace FlatlandForum\Form;

use Omelettes\Form\QuantumFilter;

class PostFieldsetFilter extends QuantumFilter
{
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = $this->getDefaultInputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'content',
				'required'		=> true,
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array(
							'encoding'	=> 'UTF-8',
							'min'		=> 1,
							'max'		=> 255,
						),
					),
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
