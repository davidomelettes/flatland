<?php

namespace FlatlandAdmin\Model;

use FlatlandGame\Model\GamesMapper as GameGamesMapper;
use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;

class GamesMapper extends GameGamesMapper
{
	protected $readOnly = false;
	
	protected function prepareSaveData(QuantumModel $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'description'	=> $model->description,
			'publisher_key'	=> $model->publisherKey ? $model->publisherKey : null,
		));
		
		return $data;
	}
	
}
