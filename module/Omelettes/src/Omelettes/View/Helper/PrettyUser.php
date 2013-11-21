<?php

namespace Omelettes\View\Helper;

class PrettyUser extends AbstractPrettifier
{
	public function __invoke($userKey, $userFullName)
	{
		return $userFullName;
	}

}
