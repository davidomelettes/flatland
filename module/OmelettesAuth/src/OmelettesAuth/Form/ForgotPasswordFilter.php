<?php

namespace OmelettesAuth\Form;

use Zend\InputFilter\InputFilter;
use Auth\Model\UsersMapper;
use Omelettes\Form\AbstractQuantumModelFilter;

class ForgotPasswordFilter extends AbstractQuantumModelFilter
{
	/**
	 * @var UsersMapper
	 */
	protected $usersMapper;
	
	public function __construct(UsersMapper $usersMapper)
	{
		$this->usersMapper = $usersMapper;
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'name',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'EmailAddress',
					),
					array(
						'name'		=> 'Omelettes\Quantum\Validator\Model\Exists',
						'options'	=> array(
							'table'		=> 'users',
							'field'		=> 'name',
							'mapper'	=> $this->usersMapper,
							'method'	=> 'fetchByName',
						),
					),
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
