<?php

namespace OmelettesLocale\Model;

use Omelettes\Model\AbstractMapper;
use OmelettesAuth\Model\User;
use Zend\Db\Sql\Predicate;

class LocaleLanguagesMapper extends AbstractMapper
{
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
		return $this->select($this->generateSqlSelect($this->getWhere(), $this->getOrder()));
	}
	
}
