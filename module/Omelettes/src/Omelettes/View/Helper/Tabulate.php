<?php

namespace Omelettes\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;

class Tabulate extends AbstractHelper
{
	public function __invoke($data)
	{
		if ($data instanceof ResultSet) {
			$mock = $data->getArrayObjectPrototype();
			
		} elseif ($data instanceof Paginator) {
			$mock = $data->getAdapter()->get
		}
	}
	
}
