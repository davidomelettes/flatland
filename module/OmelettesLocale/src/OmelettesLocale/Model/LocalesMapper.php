<?php

namespace OmelettesLocale\Model;

use Omelettes\Model\AbstractMapper;
use OmelettesAuth\Model\User;
use Zend\Db\Sql\Predicate,
	Zend\Validator\StringLength;

class LocalesMapper extends AbstractMapper
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
		$where->andPredicate(new Predicate\Operator('code', '=', $code));
		
		return $this->findOneWhere($where);
	}
	
	public function fetchAll()
	{
		return $this->select($this->getWhere(), $this->getOrder());
	}
	
	public function fetchForUser(User $user)
	{
		$where = $this->getWhere();
		$where->andPredicate(new Predicate\Operator('user_key', '=', $user->key));
		
		$order = $this->getOrder();
		
		return $this->getDependentTable('user_secondary_locales')->select(function ($select) use ($where, $order) {
			$select->where($where);
			$order($select);
		});
	}
	
	public function updateForUser(User $user, array $locales = array())
	{
		$this->beginTransaction();
		
		// Delete all existing secondary locales
		$this->getDependentTable('user_secondary_locales')->delete(array('user_key' => $user->key));
		
		// Insert new rows
		$data = array(
			'user_key' => $user->key,
		);
		foreach ($locales as $code) {
			$data['code'] = $code;
			$this->getDependentTable('user_secondary_locales')->insert($data);
		}
		
		$this->commitTransaction();
	}
	
}
