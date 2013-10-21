<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\AbstractQuantumFieldset;

class GameVariantFieldset extends AbstractQuantumFieldset
{
	public function init()
	{
		$languageOptions = array();
		$langaugesMapper = $this->getApplicationServiceLocator()->get('OmelettesLocale\Model\LocaleLanguagesMapper');
		foreach ($langaugesMapper->fetchAll() as $language) {
			$languageOptions[$language->code] = $language->name;
		}
		$this->add(array(
			'name'		=> 'language',
			'type'		=> 'Select',
			'options'	=> array(
				'label'		=> 'Language',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Language',
				'options'		=> $languageOptions,
			),
		));
	
		$editionOptions = array(
			'0'		=> 'First/Only Edition',
			'1'		=> 'Second Edition',
			'2'		=> 'Third Edition',
			'3'		=> 'Fourth Edition',
			'4'		=> 'Fifth Edition',
			'5'		=> 'Sixth Edition',
			'6'		=> 'Seventh Edition',
			'7'		=> 'Eighth Edition',
			'8'		=> 'Ninth Edition',
			'9'		=> 'Tenth Edition',
		);
		$this->add(array(
			'name'		=> 'edition',
			'type'		=> 'Select',
			'options'	=> array(
				'label'		=> 'Edition',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Edition',
				'options'		=> $editionOptions,
			),
		));
	
		$this->addNameElement();
	
		$this->add(array(
			'name'		=> 'publisher',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Publisher',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Publisher',
			),
		));
	
		$this->add(array(
			'name'		=> 'release_date',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Release Date',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'ReleaseDate',
			),
		));
	
		$this->add(array(
			'name'		=> 'description',
			'type'		=> 'Textarea',
			'options'	=> array(
				'label'		=> 'Description',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Description',
			),
		));
	}
	
}
