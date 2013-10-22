<?php

namespace Omelettes\Model;

use Omelettes\Model\AbstractMapper,
	Omelettes\Validator\Uuid\V4 as UuidValidator;
use Zend\Db\Sql\Predicate,
	Zend\Db\Sql\Select,
	Zend\Paginator\Adapter\DbSelect as PaginatorDbAdapter,
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
		return function ($select) {
			$select->order('name');
		};
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
	
	protected function getPaginator(Select $select)
	{
		if (!$this->paginator) {
			$paginationAdapter = new PaginatorDbAdapter(
				$select,
				$this->tableGateway->getAdapter(),
				$this->tableGateway->getResultSetPrototype()
			);
			$paginator = new Paginator($paginationAdapter);
			$this->paginator = $paginator;
		}
		
		return $this->paginator;
	}
	
	public function fetchAll($paginated = false)
	{
		if ($paginated) {
			$select = $this->generateSqlSelect($this->getWhere(), $this->getOrder());
			return $this->getPaginator($select);
		}
		
		return $this->select($this->generateSqlSelect($this->getWhere(), $this->getOrder()));
	}
	
}
