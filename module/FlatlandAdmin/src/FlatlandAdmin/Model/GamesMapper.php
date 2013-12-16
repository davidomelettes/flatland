<?php

namespace FlatlandAdmin\Model;

use FlatlandGame\Model\GamesMapper as GameGamesMapper;

class GamesMapper extends GameGamesMapper
{
	protected function prepareSaveData(Game $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'slug' => $model->slug ? $model->slug : null,
		));
		
		return $data;
	}
	
}
