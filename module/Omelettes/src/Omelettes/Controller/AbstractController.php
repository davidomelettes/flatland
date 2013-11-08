<?php

namespace Omelettes\Controller;

use OmelettesAuth\Authentication\AuthenticationService;
use OmelettesLocale\Model\LocalesMapper;
use Zend\Log\Logger,
	Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
	/**
	 * @var LocalesMapper
	 */
	protected $localesMapper;
	
	/**
	 * @var Logger
	 */
	protected $logger;
	
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
	
	public function getLogger()
	{
		if (!$this->logger) {
			$logger = $this->getServiceLocator()->get('Omelettes/Logger');
			$this->logger = $logger;
		}
		
		return $this->logger;
	}
	
}
