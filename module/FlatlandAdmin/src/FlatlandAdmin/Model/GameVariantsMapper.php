<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Uuid\V4 as Uuid;

class GameVariantsMapper extends QuantumMapper
{
	public function addVariant(GameVariant $variant)
	{
		$key = new Uuid();
		$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
		$variantData = array(
			'key'			=> (string)$key,
			'created_by'	=> $identity->key,
			'updated_by'	=> $identity->key,
			'game_key'		=> $variant->game,
			'language_code'	=> $variant->language,
			'edition'		=> $variant->edition,
			'description'	=> $variant->description,
			'release_date'	=> $variant->releaseDate,
			'publisher_key'	=> $variant->publisher,
		);
		
		$this->tableGateway->insert($variantData);
		
		$variant->exchangeArray($variantData);
	}
	
	
}
