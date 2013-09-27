<?php

namespace OmelettesAuth\Model;

use Omelettes\Model\QuantumMapper;
use Zend\Db\Sql\Predicate;

class UsersMapper extends QuantumMapper
{
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		$where->addPredicate(new Predicate\Operator('acl_role', '=', 'user'));
		
		return $where;
	}
	
}
