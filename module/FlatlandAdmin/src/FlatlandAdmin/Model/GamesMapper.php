<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Uuid\V4 as Uuid;
use Zend\Db\Sql\Expression;

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
		
		$game->exchangeArray($gameData);
	}
	
	public function deleteGame(Game $game)
	{
		$data = array(
			'deleted' => new Expression('now()'),
		);
		$this->tableGateway->update($data, array('key'=> $game->key));
	}
	
}
