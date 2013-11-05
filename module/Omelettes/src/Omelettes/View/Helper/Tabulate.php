<?php

namespace Omelettes\View\Helper;

use Omelettes\Model\Tabulatable,
	Omelettes\Paginator\Adapter\DbTableGateway as DbTableGatewayAdapter;
use Zend\Db\ResultSet\ResultSet,
	Zend\Paginator\Paginator,
	Zend\View\Helper\AbstractHelper;

class Tabulate extends AbstractHelper
{
	/**
	 * @var Tabulatable
	 */
	protected $mock;
	
	public function __invoke($data)
	{
		if ($data instanceof ResultSet) {
			$mock = $data->getArrayObjectPrototype();
			
		} elseif ($data instanceof Paginator) {
			$paginatorAdapter = $data->getAdapter();
			if (!$paginatorAdapter instanceof DbTableGatewayAdapter) {
				throw new \Exception('Expected instance of Omelettes\Paginator\Adapter\DbTableGateway');
			}
			$resultSetPrototype = $paginatorAdapter->getResultSetPrototype();
			$mock = $resultSetPrototype->getArrayObjectPrototype();
		}
		$this->mock = $mock;
		
		if (!$this->mock instanceof Tabulatable) {
			throw new \Exception('Result prototype does not implement Tabulatable: ' . get_class($this->mock));
		}
		
		$partialHelper = $this->view->plugin('partial');
		
		return $partialHelper('tabulate/tabulate', array(
			'data'	=> $data,
			'mock'	=> $this->mock,
		));
	}
	
}
