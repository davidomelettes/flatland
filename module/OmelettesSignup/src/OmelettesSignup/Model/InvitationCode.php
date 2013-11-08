<?php

namespace OmelettesSignup\Model;

use Omelettes\Model\QuantumModel;

class InvitationCode extends QuantumModel
{
	protected $propertyMap = array(
		'fullName'	=> 'full_name',
	);
	
	protected $fullName;
	
	public function getTableHeadings()
	{
		return array(
			'name'		=> 'Email Address',
			'fullName'	=> 'Full Name',
			'key'		=> 'Invitation Code',
		);
	}
	
	public function getTableRowPartial()
	{
		return 'tabulate/invitation';
	}
	
}
