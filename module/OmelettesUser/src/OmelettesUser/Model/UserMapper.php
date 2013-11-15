<?php

namespace OmelettesUser\Model;

use OmelettesAuth\Model\User,
	OmelettesAuth\Model\UsersMapper as AuthMapper;

class UserMapper extends AuthMapper
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
		$this->writeTableGateway->update($data, array('key' => $user->key));
	}
	
}
