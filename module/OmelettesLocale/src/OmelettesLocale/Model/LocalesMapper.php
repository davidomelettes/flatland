<?php

namespace OmelettesLocale\Model;

use Omelettes\Model\AbstractMapper;
use OmelettesAuth\Model\User;
use Zend\Db\Sql\Predicate;

class LocalesMapper extends AbstractMapper
{
	protected function getDefaultWhere()
	{
		$where = new Predicate\PredicateSet();
		
		return $where;
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
		return $this->select($this->getWhere());
	}
	
	public function fetchForUser(User $user)
	{
		$where = $this->getWhere();
		$where->andPredicate(new Predicate\Operator('user_key', '=', $user->key));
		
		return $this->select(function ($select) use ($where) {
			$select->join(
				'user_secondary_locales',
				'locales.code = user_secondary_locales.locale_code',
				'*',
				'right'
			);
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
			$data['locale_code'] = $code;
			$this->getDependentTable('user_secondary_locales')->insert($data);
		}
		
		$this->commitTransaction();
	}
	
}
