<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumMapper,
	Omelettes\Model\QuantumModel;

class ThreadsMapper extends QuantumMapper
{
	protected function getDefaultOrder()
	{
		return 'created desc';
	}
	
}
