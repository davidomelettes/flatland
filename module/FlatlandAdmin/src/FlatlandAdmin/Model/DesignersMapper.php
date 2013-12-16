<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumMapper;

class DesignersMapper extends QuantumMapper
{
	protected function prepareSaveData(Designer $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'slug' => $model->slug ? $model->slug : null,
		));
	
		return $data;
	}
	
}
