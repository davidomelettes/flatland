<?php

namespace OmelettesLocale\Model;

use Omelettes\Model\AbstractMapper;
use Zend\Db\Sql\Predicate;

class LocalesMapper extends AbstractMapper
{
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		
		return $where;
	}
	
	public function find($code)
	{
		$validator = new StringLength(array('min' => 1, 'encoding' => 'UTF-8'));
		if (!$validator->isValid($code)) {
			return false;
		}
		
		$where = $this->getWhere();
		$where->andPredicate(new Predicate\Operator('code', '=', $$code));
		
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
		throw new \Exception('Method not used!');
	}
	
}
