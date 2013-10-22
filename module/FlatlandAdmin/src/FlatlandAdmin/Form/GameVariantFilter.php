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
			
			$authService = $this->getServiceLocator()->get('AuthService');
			$filterFormat = 'Y-m-d';
			if ($authService->hasIdentity()) {
				$localesMapper = $this->getServiceLocator()->get('OmelettesLocale\Model\LocalesMapper');
				$locale = $localesMapper->find($authService->getIdentity()->locale);
				if ($locale) {
					$filterFormat = $locale->datePhpFormat;
				}
			}
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'release_date',
				'required'		=> false,
				'validators'	=> array(
					array(
						'name'		=> 'Date',
						'options'	=> array(
							'format'	=> 'Y-m-d',
						),
					),
				),
				'filters'		=> array(
					array(
						'name'		=> 'OmelettesLocale\Filter\LocaleDate',
						'options'	=> array(
							'format' => $filterFormat,
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
