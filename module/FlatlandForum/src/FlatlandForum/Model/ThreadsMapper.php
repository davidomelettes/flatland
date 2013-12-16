<?php

namespace FlatlandForum\Model;

use FlatlandGame\Model\Game;
use FlatlandGroup\Model\Group;
use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;
use Zend\Db\Sql\Predicate;

class ThreadsMapper extends QuantumMapper
{
	protected function getDefaultOrder()
	{
		return 'created desc';
	}
	
	protected function prepareSaveData(Thread $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'slug'		=> $model->slug ? $model->slug : null,
			'forum_key'	=> $model->forumKey ? $model->forumKey : null,
			'game_key'	=> $model->gameKey ? $model->gameKey : null,
			'group_key'	=> $model->groupKey ? $model->groupKey : null,
		));
		
		return $data;
	}
	
	public function fetchForForum(Forum $forum, $paginated = false)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('forum_key', '=', $forum->key));
		
		return $this->fetchAllWhere($where, $paginated);
	}
	
	public function fetchForGame(Game $game, $paginated = false)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('game_key', '=', $game->key));
	
		return $this->fetchAllWhere($where, $paginated);
	}
	
	public function fetchForGroup(Group $group, $paginated = false)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('group_key', '=', $game->key));
	
		return $this->fetchAllWhere($where, $paginated);
	}
	
}
