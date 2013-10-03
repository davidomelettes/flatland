<?php

namespace OmelettesUser\Form;

use Zend\InputFilter\InputFilterAwareInterface,
	Zend\InputFilter\InputFilterInterface,
	Zend\InputFilter\InputFilter;

class UserInfoFilter implements InputFilterAwareInterface
{
	/**
	 * @var InputFilter
	 */
	protected $inputFilter;
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('Not used');
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'full_name',
				'required'		=> 'true',
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
