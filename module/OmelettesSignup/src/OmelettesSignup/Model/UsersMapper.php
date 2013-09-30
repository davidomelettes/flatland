<?php

namespace OmelettesSignup\Model;

use Omelettes\Model\QuantumMapper;
use Omelettes\Uuid\V4 as Uuid;
use OmelettesAuth\Model\User as SignupUser;
use Zend\Validator\StringLength;
use Zend\Db\Sql\Predicate;

class UsersMapper extends QuantumMapper
{
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		$where->addPredicate(new Predicate\Operator('acl_role', '=', 'user'));
	
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
			'password_hash'		=> hash('sha256', $plaintextPassword . $salt),
			'acl_role'			=> 'user',
		);
		
		$this->tableGateway->insert($data);
		
		// Load model with new values
		$user->exchangeArray($data);
	}
	
}