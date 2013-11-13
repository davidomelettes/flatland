<?php

namespace Omelettes\Model;

use Omelettes\Model\AbstractMapper,
	Omelettes\Paginator\Adapter\DbTableGateway as DbTableGatewayAdapter,
	Omelettes\Validator\Uuid\V4 as UuidValidator;
use Zend\Db\ResultSet\ResultSet,
	Zend\Db\Sql\Predicate,
	Zend\Db\Sql\Select,
	Zend\Paginator\Paginator;

class QuantumMapper extends AbstractMapper
{
	/**
	 * @var Paginator
	 */
	protected $paginator;
	
	/**
	 * @return Predicate\PredicateSet
	 */
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		$where->addPredicate(new Predicate\IsNull('deleted'));
		
		return $where;
	}
	
	/**
	 * @return string
	 */
	protected function getDefaultOrder()
	{
		return 'name';
	}
	
	/**
	 * Returns a single result row object, or false if none found
	 *
	 * @param string $id
	 * @return QuantumModel|boolean
	 */
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
	
	/**
	 * @param PredicateSet $where
	 * @param string $order
	 * @return Paginator
	 */
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
	
	/**
	 * @param boolean $paginated
	 * @return ResultSet
	 */
	public function fetchAll($paginated = false)
	{
		if ($paginated) {
			return $this->getPaginator($this->getWhere(), $this->getOrder());
		}
		
		return $this->select($this->generateSqlSelect($this->getWhere(), $this->getOrder()));
	}
	
}
