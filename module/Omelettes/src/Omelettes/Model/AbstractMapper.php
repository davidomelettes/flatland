<?php

namespace Omelettes\Model;

use Zend\Db\Sql\Predicate,
	Zend\Db\TableGateway\TableGateway,
	Zend\ServiceManager\ServiceLocatorAwareInterface,
	Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractMapper implements ServiceLocatorAwareInterface
{
	/**
	 * @var TableGateway
	 */
	protected $tableGateway;
	
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;
	
	/**
	 * @var Predicate\PredicateSet
	 */
	protected $defaultPredicateSet;
	
	/**
	 * Array of table_names => gateways
	 * 
	 * @var array
	 */
	protected $dependantTables = array();
	
	public function __construct(TableGateway $tableGateway, array $dependantTables = array())
	{
		$this->tableGateway = $tableGateway;
		
		foreach ($dependantTables as $name => $gateway) {
			if (!$gateway instanceof TableGateway) {
				throw new \Exception('Expected a TableGateway for: ' . $name);
			}
		}
		$this->dependantTables = $dependantTables;
	}
	
	/**
	 * Returns the default clauses against which all queries must be run
	 *
	 * @return Predicate\PredicateSet
	 */
	abstract protected function getDefaultWhere();
	
	/**
	 * Returns a single result row object, or false if none found
	 *
	 * @param string $id
	 * @return ArrayObject|boolean
	 */
	abstract public function find($id);
	
	/**
	 * Returns all results
	 *
	 * @return ResultSet
	*/
	abstract public function fetchAll();
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
	protected function getConnection()
	{
		return $this->tableGateway->getAdapter()->getDriver()->getConnection();
	}
	
	/**
	 * Begin a database transaction
	 */
	public function beginTransaction()
	{
		$this->getConnection()->beginTransaction();
	}
	
	/**
	 * Roll back a database transaction
	 */
	public function rollbackTransaction()
	{
		$this->getConnection()->rollback();
	}
	
	/**
	 * Commit a database transaction
	 */
	public function commitTransaction()
	{
		$this->getConnection()->commit();
	}
	
	/**
	 * Returns a PredicateSet for use in Zend\Db\Sql selects
	 * 
	 * @return Predicate\PredicateSet
	 */
	final public function getWhere()
	{
		if (!$this->defaultPredicateSet) {
			$defaultWhere = $this->getDefaultWhere();
			if (!$defaultWhere instanceof Predicate\PredicateSet) {
				throw new \Exception('Expected a PredicateSet');
			}
			$this->defaultPredicateSet = $defaultWhere;
		}
		
		return clone $this->defaultPredicateSet;
	}
	
	/**
	 * Returns a single row object, or false if none found
	 * 
	 * @param Predicate\PredicateSet $where
	 * @return boolean|ArrayObject
	 */
	protected function findOneWhere(Predicate\PredicateSet $where)
	{
		$rowset = $this->select($where);
		$row = $rowset->current();
		if (!$row) {
			return false;
		}
		
		return $row;
	}
	
	/**
	 * Returns all results matching specified predicates
	 * 
	 * @param PredicateInterface $where
	 * @return ResultSet
	 */
	protected function fetchAllWhere(Predicate\PredicateInterface $where)
	{
		return $this->select($where);
	}
	
	/**
	 * Performs a select on the tableGateway
	 * 
	 * @param Predicate\PredicateSet|Closure $where
	 * @return ResultSet
	 */
	protected function select($where)
	{
		if ($where instanceof Predicate\PredicateSet && count($where) < 1) {
			// Prevent empty PredicateSets from generating bad SQL 
			$where = null;
		}
		return $this->tableGateway->select($where);
	}
	
	/**
	 * Allows access to a dependent table gatweway
	 * 
	 * @param string $name
	 * @throws \Exception
	 * @return TableGateway
	 */
	protected function getDependentTable($name)
	{
		if (!isset($this->dependantTables[$name])) {
			throw new \Exception($name . ' is not a dependent table');
		}
		return $this->dependantTables[$name];
	}
	
}