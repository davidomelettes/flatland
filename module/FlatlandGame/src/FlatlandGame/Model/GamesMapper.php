<?php

namespace FlatlandGame\Model;

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
			'name'				=> $game->name,
			'created_by'		=> $identity->key,
			'updated_by'		=> $identity->key,
		);
		
		$affectedRows = $this->tableGateway->insert($gameData);
		var_dump($affectedRows);die();
		
		$game->exchangeArray($gameData);
	}
	
}
