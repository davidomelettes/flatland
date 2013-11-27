<?php

namespace FlatlandList\Form;

use FlatlandGame\Model\GamesMapper;
use Omelettes\Form\QuantumFilter,
	Omelettes\Validator\Model\ModelExists,
	Omelettes\Validator\Uuid\V4 as UuidValidator;

class AddListItemFilter extends QuantumFilter
{
	/**
	 * @var GamesMapper
	 */
	protected $gamesMapper;
	
	public function __construct(GamesMapper $mapper)
	{
		$this->gamesMapper = $mapper;
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = $this->getDefaultInputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'game_key',
				'required'		=> true,
				'validators'	=> array(
					array(
						'name'						=> 'Omelettes\Validator\Uuid\V4',
						'break_chain_on_failure'	=> true,
					),
					array(
						'name'		=> 'Omelettes\Validator\Model\ModelExists',
						'options'	=> array(
							'mapper'	=> $this->gamesMapper,
							'method'	=> 'find',
							'messages'	=> array(
								ModelExists::ERROR_MODEL_DOES_NOT_EXIST => 'Game not found',
							),
						),
					),
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
