<?php

namespace FlatlandAdmin\Model;

use FlatlandForum\Model\Forum as ForumForum;

class Forum extends ForumForum
{
	public function getTableRowPartial()
	{
		return 'tabulate/quantum';
	}
	
}
