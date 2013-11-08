<?php

namespace OmelettesSignup\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Uuid\V4 as Uuid;
use OmelettesSignup\Model\InvitationCode;
use Zend\Db\Sql\Predicate;

class InvitationCodesMapper extends QuantumMapper
{
	public function saveInvitation(InvitationCode $invitation)
	{
		$auth = $this->getServiceLocator()->get('AuthService');
		$code = new Uuid();
		$data = array(
			'key'			=> (string)$code,
			'name'			=> $invitation->name,
			'created_by'	=> $auth->getIdentity()->key,
			'updated_by'	=> $auth->getIdentity()->key,
		);
		$this->tableGateway->insert($data);
		
		$invitation->exchangeArray($data);
	}
	
	public function findByName($emailAddress)
	{
		$where = $this->getWhere();
		$where->addPredicate(new Predicate\Operator('name', '=', $emailAddress));
	
		return $this->findOneWhere($where);
	}
	
}
