<?php

namespace OmelettesAuth\Model;

use Omelettes\Model\QuantumModel;

class User extends QuantumModel
{
	protected $fullName;
	protected $aclRole;
	protected $locale;
	
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
		$this->setFullName(isset($data['full_name']) ? $data['full_name'] : null);
		$this->setAclRole(isset($data['acl_role']) ? $data['acl_role'] : null);
		$this->setLocale(isset($data['locale']) ? $data['locale'] : null);
	
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
			'full_name'			=> $this->fullName,
			'acl_role'			=> $this->aclRole,
			'locale'			=> $this->locale,
		));
	}
	
	public function setFullName($name)
	{
		$this->fullName = $name;
	
		return $this;
	}
	
	public function getFullName()
	{
		return $this->fullName;
	}
	
	public function setAclRole($role)
	{
		$this->aclRole = $role;
	
		return $this;
	}
	
	public function getAclRole()
	{
		return $this->aclRole;
	}
	
	public function setLocale($code)
	{
		$this->locale = $code;
		
		return $this;
	}
	
	public function getLocale()
	{
		return $this->locale;
	}
	
}
