<?php

namespace Omelettes\Model;

use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

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
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}

	/**
	 * Returns the default clauses against which all queries must be run
	 * 
	 * @return Predicate\PredicateSet
	 */
	abstract protected function getDefaultWhere();
	
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
			$this->defaultPredicateSet = $where;
		}
		
		return $this->defaultPredicateSet;
	}
	
	/**
	 * Returns a single result row object, or false if none found
	 * 
	 * @param string $id
	 * @return ArrayObject|boolean 
	 */
	abstract public function find($id);
	
	/**
	 * Performs a find via specified table column
	 * 
	 * @param string $property
	 * @param mixed $value
	 * @return ArrayObject|boolean
	 */
	abstract public function findBy($property, $value);
	
	/**
	 * Returns all results
	 * 
	 * @return ResultSet
	 */
	abstract public function fetchAll();
	
	/**
	 * Returns all results matching specified predicates
	 * 
	 * @param PredicateInterface $where
	 * @return ResultSet
	 */
	abstract public function fetchAllWhere(Predicate\PredicateInterface $where);
	
}