<?php

namespace FlatlandGame\Model;

use FlatlandForum\Model as ForumModel;

class Thread extends ForumModel\Thread
{
	public function getTableRowPartial()
	{
		return 'tabulate/thread-game';
	}
	
}
