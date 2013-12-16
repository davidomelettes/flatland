<?php

namespace FlatlandList\Model;

use FlatlandGame\Model\Game;
use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;
use Zend\Db\Sql\Predicate;

class TopListsMapper extends QuantumMapper
{
	public function fetchForGame(Game $game, $paginated = false)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('key', '=', $game->key));
		
		return $this->fetchAllWhere($where, $paginated);
	}
	
}
