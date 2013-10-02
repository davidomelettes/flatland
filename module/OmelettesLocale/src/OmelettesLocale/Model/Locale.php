<?php

namespace OmelettesLocale\Model;

use Omelettes\Model\AbstractModel;

class Locale extends AbstractModel
{
	protected $code;
	protected $name;
	
	public function exchangeArray($data)
	{
		$this->setCode(isset($data['code']) ? $data['code'] : null)
			->setName(isset($data['name']) ? $data['name'] : null);
	
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array(
			'code'		=> $this->code,
			'name'		=> $this->name,
		);
	}
	
	public function setCode($code)
	{
		$this->code = (string)$code;
	
		return $this;
	}
	
	public function getCode()
	{
		return $this->code;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	
		return $this;
	}
	
	public function getName()
	{
		return $this->name;
	}
}
