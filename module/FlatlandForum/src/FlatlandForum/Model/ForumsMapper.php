<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel,
	Omelettes\Validator;
use Zend\Db\Sql\Predicate;

class ForumsMapper extends QuantumMapper
{
	protected function prepareSaveData(Forum $model)
	{
		$data = parent::prepareSaveData($model);
	
		return $data;
	}
	
	public function findBySlug($slug)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('slug', '=', $slug));
		
		return $this->findOneWhere($where);
	}
	
	public function generateSlug($name)
	{
		$name = strtolower($name);
		$replacements = array(
			'/\s+/' => '-',
			'/[^a-z0-9]/' => '',
		);
		$slug = preg_replace(array_keys($replacements), array_values($replacements), $name);
		
		return $slug;
	}
	
}
