<?php

namespace Omelettes\Model;

use Omelettes\Db\Sql\Predicate as OmelettesPredicate,
	Omelettes\Paginator\Adapter\DbTableGateway as DbTableGatewayAdapter,
	Omelettes\Paginator\Paginator,
	Omelettes\Uuid\V4 as Uuid,
	Omelettes\Validator\Uuid\V4 as UuidValidator;
use Zend\Db\ResultSet\ResultSet,
	Zend\Db\Sql\Expression,
	Zend\Db\Sql\Predicate,
	Zend\Db\Sql\Select;

abstract class QuantumMapper extends AbstractMapper
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
		return $this->fetchAllWhere($this->getWhere(), $paginated);
	}
	
	public function fetchAllWhere(Predicate\PredicateSet $where, $paginated = false)
	{
		if ($paginated) {
			return $this->getPaginator($where, $this->getOrder());
		}
		
		return $this->select($this->generateSqlSelect($where, $this->getOrder()));
	}
	
	public function fetchAllWhereNameLike($term, $paginated = false)
	{
		$where = $this->getWhere();
		if (!is_null($term) && '' !== $term) {
			$where->addPredicate(new OmelettesPredicate\Ilike('name', $term.'%'));
		}
		
		return $this->fetchAllWhere($where, $paginated);
	}
	
	public function createQuantum(QuantumModel $model)
	{
		$key = new Uuid();
		$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
		$data = array(
			'key'				=> (string)$key,
			'name'				=> $model->name,
			'created_by'		=> $identity->key,
			'updated_by'		=> $identity->key,
		);
		
		$this->tableGateway->insert($data);
		$model->exchangeArray($data);
	}
	
	public function updateQuantum(QuantumModel $model)
	{
		$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
		$data = array(
			'name'				=> $model->name,
			'updated_by'		=> $identity->key,
			'updated'			=> new Expression('now()'),
		);
		
		$this->tableGateway->update($data, array('key' => $model->key));
		$model->exchangeArray($data);
	}
	
	public function deleteQuantum(QuantumModel $model)
	{
		$data = array(
			'deleted' => new Expression('now()'),
		);
		$this->tableGateway->update($data, array('key'=> $model->key));
	}
	
}
