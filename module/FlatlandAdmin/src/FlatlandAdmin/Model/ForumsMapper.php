<?php

namespace FlatlandAdmin\Model;

use FlatlandForum\Model\ForumsMapper as ForumForumsMapper;
use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;

class ForumsMapper extends ForumForumsMapper
{
	protected function prepareSaveData(QuantumModel $model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'slug' => $this->generateSlug($model->name),
		));
		
		return $data;
	}
	
}
