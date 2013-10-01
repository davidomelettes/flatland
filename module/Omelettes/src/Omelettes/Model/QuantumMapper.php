<?php

namespace Omelettes\Model;

use Omelettes\Model\AbstractMapper;
use Omelettes\Validator\Uuid\V4 as UuidValidator;
use Zend\Db\Sql\Predicate;

class QuantumMapper extends AbstractMapper
{
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		
		return $where;
	}
	
	public function find($key)
	{
		$validator = new UuidValidator();
		if (!$validator->isValid($key)) {
			return false;
		}
		
		$where = $this->getWhere();
		$where->andPredicate(new Predicate\Operator('key', '=', $key));
		
		return $this->findOneWhere($where);
	}
	
	public function fetchAll()
	{
		$where = $this->getWhere();
		$resultSet = $this->tableGateway->select($where);
		
		return $resultSet;
	}
	
	public function fetchAllWhere(Predicate\PredicateInterface $where)
	{
		$defaultWhere = $this->getWhere();
		$defaultWhere->addPredicate($where);
		$resultSet = $this->tableGateway->select($defaultWhere);
		
		return $resultSet;
	}
	
}
