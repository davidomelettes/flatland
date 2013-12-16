<?php

namespace FlatlandGroup\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;

class GroupsMapper extends QuantumMapper
{
	protected function prepareSaveData(Group $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'slug' => $model->slug ? $model->slug : null,
		));
	
		return $data;
	}
}
