<?php

namespace FlatlandMember\Model;

use OmelettesAuth\Model\User;

class Member extends User
{
	public function getTableHeadings()
	{
		$headings = parent::getTableHeadings();
		$headings = array_merge($headings, array(
			'created' => 'Member Since',
		));
	
		return $headings;
	}
	
	public function getTableRowPartial()
	{
		return 'tabulate/member';
	}
	
	public function getName()
	{
		throw new \Exception('Security breach!');
	}
	
}
