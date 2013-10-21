<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\AbstractQuantumModelFilter;

class GameVariantFilter extends AbstractQuantumModelFilter
{
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = parent::getInputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'publisher',
				'required'		=> false,
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
			)));
			
			$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
			$localesMapper = $this->getServiceLocator()->get('OmelettesLocale\Model\LocalesMapper');
			$locale = $localesMapper->find($identity->locale);
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'release_date',
				'required'		=> false,
				'validators'	=> array(
					array(
						'name'		=> 'Date',
						'options'	=> array(
							'format'	=> $locale->datePhpFormat,
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'description',
				'required'		=> false,
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
