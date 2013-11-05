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
			'1'		=> 'First/Only Edition',
			'2'		=> 'Second Edition',
			'3'		=> 'Third Edition',
			'4'		=> 'Fourth Edition',
			'5'		=> 'Fifth Edition',
			'6'		=> 'Sixth Edition',
			'7'		=> 'Seventh Edition',
			'8'		=> 'Eighth Edition',
			'9'		=> 'Ninth Edition',
			'10'	=> 'Tenth Edition',
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
