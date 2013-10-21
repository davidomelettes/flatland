<?php

namespace OmelettesLocale\Model;

use Omelettes\Model\AbstractModel;

class LocaleLanguage extends AbstractModel
{
	protected $code;
	protected $name;
	protected $native;
	
	public function exchangeArray($data)
	{
		$this->setCode(isset($data['code']) ? $data['code'] : null)
			->setName(isset($data['name']) ? $data['name'] : null)
			->setNative(isset($data['native']) ? $data['native'] : null);
	
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array(
			'code'		=> $this->code,
			'name'		=> $this->name,
			'native'	=> $this->native,
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
	
	public function setNative($native)
	{
		$this->native = $native;
	
		return $this;
	}
	
	public function getNative()
	{
		return $this->native;
	}
	
}
