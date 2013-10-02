<?php

namespace OmelettesUser\Form;

use Omelettes\Form\AbstractQuantumForm;

class UserInfoForm extends AbstractQuantumForm
{
	/**
	 * @var array
	 */
	protected $localeOptions;
	
	public function __construct()
	{
		parent::__construct('form-user-info');
	}
	
	public function init()
	{
		$this->add(array(
			'name'		=> 'name',
			'type'		=> 'StaticValue',
			'options'	=> array(
				'label'		=> 'Email Address',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Name',
			),
		));
		
		$this->add(array(
			'name'		=> 'full_name',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Full Name',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'FullName',
			),
		));
		
		$this->add(array(
			'name'		=> 'password',
			'type'		=> 'StaticValue',
			'options'	=> array(
				'label'		=> 'Password',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Password',
				'value'		=> '************',
			),
		));
	}
	
	public function addLocaleElement(array $localeOptions = array())
	{
		$this->add(array(
			'name'		=> 'locale',
			'type'		=> 'Select',
			'options'	=> array(
				'label'		=> 'Locale',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Locale',
				'options'=> $localeOptions,
			),
		));
	}
	
}
