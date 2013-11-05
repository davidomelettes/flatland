<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form;
use Omelettes\Controller\AbstractController;
use OmelettesAuth\Model\UsersMapper;

class UsersController extends AbstractController
{
	/**
	 * @var UsersMapper
	 */
	protected $usersMapper;
	
	public function getUsersMapper()
	{
		if (!$this->usersMapper) {
			$usersMapper = $this->getServiceLocator()->get('OmelettesAuth\Model\UsersMapper');
			$this->usersMapper = $usersMapper;
		}
		
		return $this->usersMapper;
	}
	
	public function indexAction()
	{
		$paginator = $this->getUsersMapper()->fetchAll(true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		
		return array(
			'users' => $paginator,
		);
	}
	
}
