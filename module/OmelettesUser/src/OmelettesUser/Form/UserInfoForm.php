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
	
	/**
	 * Form construction goes here because we have
	 * non-standard form_elements we want initialised
	 */
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
		
		$localesMapper = $this->getApplicationServiceLocator()->get('OmelettesLocale\Model\LocalesMapper');
		$localeOptions = array();
		foreach ($localesMapper->fetchAll() as $locale) {
			$localeOptions[$locale->code] = $locale->name;
		}
		$this->add(array(
			'name'		=> 'locale',
			'type'		=> 'Select',
			'options'	=> array(
				'label'		=> 'Primary Locale',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Locale',
				'options'=> $localeOptions,
			),
		));
		
		$secondaryLocaleOptions = array();
		$identity = $this->getApplicationServiceLocator()->get('AuthService')->getIdentity();
		foreach ($localesMapper->fetchForUser($identity) as $locale) {
			$secondaryLocaleOptions[$locale->code] = $locale->name;
		}
		$secondaryLocales = $localesMapper->fetchForUser($identity);
		$secondaryLocalesValue = array();
		foreach ($secondaryLocales as $locale) {
			$secondaryLocalesValue[] = $locale->code;
		}
		$this->add(array(
			'name'		=> 'secondary_locales',
			'type'		=> 'Select',
			'options'	=> array(
				'label'		=> 'Secondary Locales',
			),
			'attributes'=> array(
				'multiple'	=> 'multiple',
				'id'		=> $this->getName() . 'SecondaryLocales',
				'options'	=> $localeOptions,
				'value'		=> $secondaryLocalesValue,
			),
		));
		
		$this->addSubmitElement();
	}
	
}
