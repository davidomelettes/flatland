<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;

class GamesMapper extends QuantumMapper
{
	protected function prepareSaveData(QuantumModel $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'description'	=> $model->description,
			'publisher_key'	=> $model->publisherKey,
		));
		
		return $data;
	}
	
}
