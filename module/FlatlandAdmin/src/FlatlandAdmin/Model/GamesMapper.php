<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Uuid\V4 as Uuid;

class GamesMapper extends QuantumMapper
{
	public function addGame(Game $game)
	{
		$key = new Uuid();
		$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
		$gameData = array(
			'key'				=> (string)$key,
			'name'				=> $game->variant->name,
			'created_by'		=> $identity->key,
			'updated_by'		=> $identity->key,
		);
		
		$variantsMapper = $this->getServiceLocator()->get('FlatlandAdmin\Model\GameVariantsMapper');
		
		$this->beginTransaction();
		
		$this->tableGateway->insert($gameData);
		$game->variant->game = (string)$key;
		$variantsMapper->addVariant($game->variant);
		
		$this->commitTransaction();
		
		$game->exchangeArray($gameData);
	}
	
}
