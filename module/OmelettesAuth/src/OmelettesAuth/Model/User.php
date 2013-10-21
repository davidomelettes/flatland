<?php

namespace OmelettesAuth\Model;

use Omelettes\Model\QuantumModel;
use Zend\Permissions\Acl\Acl;

class User extends QuantumModel
{
	protected $propertyMap = array(
		'fullName'	=> 'full_name',
		'aclRole'	=> 'acl_role',
		'locale'	=> 'locale',
	);
	
	protected $fullName;
	protected $aclRole;
	protected $locale;
	
	protected $passwordAuthenticated = false;
	
	public function setPasswordAuthenticated($authenticated = true)
	{
		$this->passwordAuthenticated = (boolean)$authenticated;
	}
	
	public function isPasswordAuthenticated()
	{
		return $this->passwordAuthenticated;
	}
	
}
