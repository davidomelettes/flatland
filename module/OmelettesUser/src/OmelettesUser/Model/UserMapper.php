<?php

namespace OmelettesUser\Model;

use Omelettes\Model\QuantumMapper;
use OmelettesAuth\Model\User;

class UserMapper extends QuantumMapper
{
	public function updateUser(User $user)
	{
		if (!$this->find($user->key)) {
			throw new \Exception('User with key ' . $user->key . ' does not exist');
		}
		
		$data = array(
			'full_name'			=> $user->fullName,
			'locale'			=> $user->locale,
		);
		$this->tableGateway->update($data, array('key' => $user->key));
		
		$user->exchangeArray($data);
	}
	
}
