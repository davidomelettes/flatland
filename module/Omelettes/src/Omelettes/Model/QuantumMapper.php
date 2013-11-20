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
				$this->readTableGateway,
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
	
	public function findByName($name)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('name', '=', $name));
		
		return $this->findOneWhere($where);
	}
	
	protected function prepareSaveData(QuantumModel $model)
	{
		$key = $model->key;
		$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
		$data = array(
			'name'				=> $model->name,
			'updated_by'		=> $identity->key,
			'updated'			=> new Expression('now()'),
		);
		if (!$key) {
			// Creating
			$key = new Uuid();
			$data = array_merge($data, array(
				'key'			=> (string)$key,
				'created_by'	=> $identity->key,
			));
		}
		
		return $data;
	}
	
	public function saveQuantum(QuantumModel $model)
	{
		$key = $model->key;
		$data = $this->prepareSaveData($model);
		if ($key) {
			// Updating
			$this->writeTableGateway->update($data, array('key' => $key));
			$data['key'] = $key;
		} else {
			// Creating
			$this->writeTableGateway->insert($data);
		}
		
		// Rehydrate
		$model->exchangeArray($data);
	}
	
	public function createQuantum(QuantumModel $model)
	{
		return $this->saveQuantum($model);
	}
	
	public function updateQuantum(QuantumModel $model)
	{
		return $this->saveQuantum($model);
	}
	
	public function deleteQuantum(QuantumModel $model)
	{
		$data = array(
			'deleted' => new Expression('now()'),
		);
		$this->writeTableGateway->update($data, array('key'=> $model->key));
	}
	
}
