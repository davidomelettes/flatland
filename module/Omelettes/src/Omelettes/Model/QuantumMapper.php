<?php

namespace Omelettes\Model;

use Omelettes\Model\AbstractMapper,
	Omelettes\Paginator\Adapter\DbTableGateway as DbTableGatewayAdapter,
	Omelettes\Validator\Uuid\V4 as UuidValidator;
use Zend\Db\Sql\Predicate,
	Zend\Db\Sql\Select,
	Zend\Paginator\Paginator;

class QuantumMapper extends AbstractMapper
{
	/**
	 * @var Paginator
	 */
	protected $paginator;
	
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		
		return $where;
	}
	
	protected function getDefaultOrder()
	{
		return 'name';
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
	
	protected function getPaginator($where, $order = null)
	{
		if (!$this->paginator) {
			if ($where instanceof Predicate\PredicateSet && count($where) < 1) {
				$where = null;
			}
			$paginationAdapter = new DbTableGatewayAdapter(
				$this->tableGateway,
				$where,
				$order
			);
			$paginator = new Paginator($paginationAdapter);
			$this->paginator = $paginator;
		}
		
		return $this->paginator;
	}
	
	public function fetchAll($paginated = false)
	{
		if ($paginated) {
			return $this->getPaginator($this->getWhere(), $this->getOrder());
		}
		
		return $this->select($this->generateSqlSelect($this->getWhere(), $this->getOrder()));
	}
	
}
