<?php

namespace OmelettesSignup\Model;

use Omelettes\Model\QuantumModel;

class InvitationCode extends QuantumModel
{
	protected $propertyMap = array(
		'fullName'	=> 'full_name',
	);
	
	protected $fullName;
	
}
