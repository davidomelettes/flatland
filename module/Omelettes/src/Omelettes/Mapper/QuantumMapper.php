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
		
		return $this->findBy('key', $key);
	}
	
	public function findBy($property, $value)
	{
		if (method_exists($this, 'findBy'.$property)) {
			return $this->$methodName($value);
		}
		
		$where = $this->getWhere();
		$where->andPredicate(new Predicate\Operator($property, '=', $value));
		
		$rowset = $this->tableGateway->select($where);
		$row = $rowset->current();
		if (!$row) {
			return false;
		}
		
		return $row;
	}
	
	public function fetchAll()
	{
		$where = $this->getWhere();
		$resultSet = $this->tableGateway->select($where);
		
		return $resultSet;
	}
	
	public function fetchAllWhere(PredicateInterface $where)
	{
		$defaultWhere = $this->getWhere();
		$defaultWhere->addPredicate($where);
		$resultSet = $this->tableGateway->select($defaultWhere);
		
		return $resultSet;
	}
	
}
