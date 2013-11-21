<?php

namespace OmelettesAuth\Model;

use Omelettes\Uuid\V4 as Uuid;
use OmelettesSignup\Model\UsersMapper as SignupMapper;
use Zend\Db\Sql\Predicate,
	Zend\Validator\StringLength;

class UsersMapper extends SignupMapper
{
	protected $readOnly = true;
	
	public function regeneratePasswordResetKey(User $user)
	{
		if (!$this->find($user->key)) {
			throw new \Exception('User with key ' . $user->key . ' does not exist');
		}
		
		$key = new Uuid();
		$data = array(
			'password_reset_key'		=> $key,
			'password_reset_requested'	=> 'now()',
		);
		$this->writeTableGateway->update($data, array('key' => $user->key));
		
		return (string)$key;
	}
	
	public function updatePassword(User $user, $plaintextPassword)
	{
		if (!$this->find($user->key)) {
			throw new \Exception('User with key ' . $user->key . ' does not exist');
		}
		$salt = new Uuid();
		$data = array(
			'salt'						=> $salt,
			'password_hash'				=> $this->generatePasswordHash($plaintextPassword, $salt),
			'password_reset_key'		=> null,
			'password_reset_requested'	=> null,
		);
		$this->writeTableGateway->update($data, array('key' => $user->key));
	}
	
	public function getSystemIdentity($systemIdentityKey)
	{
		// Don't use the default WHERE predicates
		$predicateSet = new Predicate\PredicateSet();
		$predicateSet->addPredicate(new Predicate\Operator('acl_role', '=', 'system'));
		$predicateSet->addPredicate(new Predicate\Operator('key', '=', $systemIdentityKey));
		
		return $this->findOneWhere($predicateSet);
	}
	
}
