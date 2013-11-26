<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;
use Zend\Db\Sql\Predicate;

class PostsMapper extends QuantumMapper
{
	protected function prepareSaveData(QuantumModel $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'content'		=> $model->content,
			'thread_key'	=> $model->threadKey ? $model->threadKey : null,
		));
		
		return $data;
	}
	
	public function fetchForThread(Thread $thread, $paginated = false)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('thread_key', '=', $thread->key));
		
		return $this->fetchAllWhere($where, $paginated);
	}
	
}
