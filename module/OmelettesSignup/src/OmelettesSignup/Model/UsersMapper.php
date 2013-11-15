<?php

namespace OmelettesSignup\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Uuid\V4 as Uuid;
use OmelettesAuth\Model\User as SignupUser;
use Zend\Validator\StringLength,
	Zend\Db\Sql\Predicate;

class UsersMapper extends QuantumMapper
{
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		$where->addPredicate(new Predicate\Operator('acl_role', '!=', 'system'));
	
		return $where;
	}
	
	public function findByName($name)
	{
		$validator = new StringLength(array('min' => 1, 'encoding' => 'UTF-8'));
		if (!$validator->isValid($name)) {
			return false;
		}
	
		$where = $this->getWhere();
		$where->andPredicate(new Predicate\Operator('name', '=', $name));
	
		return $this->findOneWhere($where);
	}
	
	public function signupUser(SignupUser $user, $plaintextPassword)
	{
		$config = $this->getServiceLocator()->get('config');
		$key = new Uuid();
		$salt = new Uuid();
		$data = array(
			'key'				=> $key,
			'name'				=> $user->name,
			'created_by'		=> $config['user_keys']['SYSTEM_SIGNUP'],
			'updated_by'		=> $config['user_keys']['SYSTEM_SIGNUP'],
			'full_name'			=> $user->fullName,
			'salt'				=> $salt,
			'password_hash'		=> $this->generatePasswordHash($plaintextPassword, $salt),
			'acl_role'			=> 'user',
			'locale'			=> 'en_GB',
		);
		
		$this->writeTableGateway->insert($data);
		
		// Load model with new values
		$user->exchangeArray($data);
	}
	
	protected function generatePasswordHash($plaintextPassword, $salt)
	{
		return hash('sha256', $plaintextPassword . $salt);
	}
	
}
