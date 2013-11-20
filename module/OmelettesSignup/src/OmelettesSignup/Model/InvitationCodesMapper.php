<?php

namespace OmelettesSignup\Model;

use Omelettes\Model\QuantumMapper;

class InvitationCodesMapper extends QuantumMapper
{
	public function prepareSaveData($model)
	{
		$data = parent::prepareSaveData($model);
		$data = array_merge($data, array(
			'full_name'		=> $model->fullName,
		));
		
		return $data;
	}
	
}
