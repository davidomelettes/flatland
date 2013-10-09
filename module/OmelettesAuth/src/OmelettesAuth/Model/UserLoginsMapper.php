<?php

namespace OmelettesAuth\Model;

use Omelettes\Model\AbstractMapper, 
	Omelettes\Uuid\V4 as Uuid;
use Zend\Db\Sql\Predicate,
	Zend\Validator\StringLength;

class UserLoginsMapper extends AbstractMapper
{
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		
		return $where;
	}
	
	public function find($id)
	{
		throw new \Exception('Method not used');
	}
	
	public function fetchAll()
	{
		throw new \Exception('Method not used');
	}
	
	public function splitCookieData($string)
	{
		$data = explode(',', $string);
		if (3 !== count($data)) {
			return false;
		}
		return array(
			'name'		=> $data[0],
			'series'	=> $data[1],
			'token'		=> $data[2],
		);
	}
	
	public function saveLogin($name, $series = null)
	{
		$token = new Uuid();
		if (null === $series) {
			$series = new Uuid();
		}
		$data = array(
			'name'		=> $name,
			'series'	=> (string)$series,
			'token'		=> (string)$token,
		);
		$this->tableGateway->insert($data);
		
		return implode(',', array($data['name'], $data['series'], $data['token']));
	}
	
	/**
	 * Removes all login tokens
	 * Used when logging out, or in event of suspect cookie theft
	 * 
	 * @param string $name
	 */
	public function deleteForName($name)
	{
		$this->tableGateway->delete(array('name' => $name));
	}
	
	public function verifyCookie($cookieData)
	{
		$data = explode(',', $cookieData);
		if (3 !== count($data)) {
			return false;
		}
		$name = $data[0];
		$series = $data[1];
		$token = $data[2];
		
		$where = $this->getWhere();
		$where->andPredicate(new Predicate\Operator('name', '=', $name));
		$where->andPredicate(new Predicate\Operator('series', '=', $series));
		$where->andPredicate(new Predicate\Operator('token', '=', $token));
		
		$result = $this->findOneWhere($where);
		if ($result) {
			// Delete the triplet
			$this->tableGateway->delete(array('name' => $name, 'series' => $series, 'token' => $token));
			
			// Issue a new token in this series
			return $this->saveLogin($name, $series);
			
		} else {
			// Check for series theft
			$where = $this->getWhere();
			$where->andPredicate(new Predicate\Operator('name', '=', $name));
			$where->andPredicate(new Predicate\Operator('series', '=', $series));
			
			$result = $this->findOneWhere($where);
			if ($result) {
				// Panic! Delete all login tokens
				// TODO: Alert user
				$this->deleteForName($name);
			}
			
			return false;
		}
	}
	
}
