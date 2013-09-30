<?php

namespace OmelettesAuth\Model;

use Omelettes\Model\QuantumMapper;
use Zend\Db\Sql\Predicate;
use Zend\Validator\StringLength;

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
		$where->andPredicate(new Predicate\Operator('name', '=', $value));
		
		return $this->findOneWhere($where);
	}
	
}
