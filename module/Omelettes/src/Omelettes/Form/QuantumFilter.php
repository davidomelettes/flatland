<?php

namespace Omelettes\Form;

use Zend\InputFilter\InputFilter,
	Zend\InputFilter\InputFilterAwareInterface,
	Zend\InputFilter\InputFilterInterface,
	Zend\ServiceManager\ServiceLocatorAwareInterface,
	Zend\ServiceManager\ServiceLocatorInterface,
	Zend\Validator\ValidatorChain;

class QuantumFilter implements InputFilterAwareInterface, ServiceLocatorAwareInterface
{
	/**
	 * @var InputFilter
	 */
	protected $inputFilter;
	
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('Not used');
	}
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}

	protected function getDefaultInputFilter()
	{
		$inputFilter = new InputFilter();
		
		// We've got to do all this jiggery-pokery because otherwise
		// the input factory will not be aware of validators defined in the module config
		$factory = $inputFilter->getFactory();
		$validatorMananger = $this->getServiceLocator()->get('ValidatorManager');
		$chain = new ValidatorChain();
		$chain->setPluginManager($validatorMananger);
		$factory->setDefaultValidatorChain($chain);
		
		return $inputFilter;
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = $this->getDefaultInputFilter();
			$factory = $inputFilter->getFactory();
				
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'name',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StripTags'),
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
