<?php

namespace Omelettes\Controller;

use Zend\Authentication\AuthenticationService,
	Zend\Mvc\Controller\AbstractRestfulController as ZendRestfulController;
use OmelettesLocale\Model\LocalesMapper;

abstract class AbstractRestfulController extends ZendRestfulController
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
	/**
	 * @var LocalesMapper
	 */
	protected $localesMapper;
	
	public function getAuthService()
	{
		if (!$this->authService) {
			$authService = $this->getServiceLocator()->get('AuthService');
			$this->authService = $authService;
		}
		
		return $this->authService;
	}
	
	public function getLocalesMapper()
	{
		if (!$this->localesMapper) {
			$localesMapper = $this->getServiceLocator()->get('OmelettesLocale\Model\LocalesMapper');
			$this->localesMapper = $localesMapper;
		}
		
		return $this->localesMapper;
	}
	
}
