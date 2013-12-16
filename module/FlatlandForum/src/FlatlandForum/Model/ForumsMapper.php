<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel,
	Omelettes\Validator;
use Zend\Db\Sql\Predicate;

class ForumsMapper extends QuantumMapper
{
	protected function prepareSaveData(Forum $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'slug' => $model->slug ? $model->slug : null,
		));
		
		return $data;
	}
	
}
