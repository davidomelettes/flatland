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
	
	public function getAvatarUrl($size = '50')
	{
		$hash = md5($this->name);
		$default = 'retro';
		return sprintf('http://www.gravatar.com/avatar/%s?s=%d&amp;d=%s.jpg', $hash, $size, $default);
	} 
	
}
