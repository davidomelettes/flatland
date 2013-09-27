<?php

namespace OmelettesAuth\Model;

use Omelettes\Model\QuantumModel;

class User extends QuantumModel
{
	protected $fullName;
	protected $enabled;
	protected $aclRole;
	
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
		$this->setFullName(isset($data['full_name']) ? $data['full_name'] : null);
		$this->setEnabled(isset($data['enabled']) ? $data['enabled'] : null);
		$this->setAclRole(isset($data['acl_role']) ? $data['acl_role'] : null);
	
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
			'full_name'			=> $this->fullName,
			'enabled'			=> $this->enabled,
			'acl_role'			=> $this->aclRole,
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
	
	public function setEnabled($enabled)
	{
		$this->enabled = (boolean)$enabled;
	
		return $this;
	}
	
	public function getEnabled()
	{
		return $this->enabled;
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
	
}
