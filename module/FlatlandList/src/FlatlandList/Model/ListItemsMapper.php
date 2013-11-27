<?php

namespace FlatlandList\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;
use Zend\Db\Sql\Predicate;

class ListItemsMapper extends QuantumMapper
{
	protected function getDefaultOrder()
	{
		return 'list_order';
	}
	
	public function fetchForList(TopList $list, $paginated = true)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('list_key', '=', $list->key));
		
		return $this->fetchAllWhere($where, $paginated);
	}
	
	protected function prepareSaveData(ListItem $model)
	{
		$data = array(
			'game_key'		=> $model->gameKey,
			'list_key'		=> $model->listKey,
			'list_order'	=> (int)$model->listOrder,
		);
		
		return $data;
	}
	
}
