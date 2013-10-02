<?php

namespace OmelettesAuth\View\Helper;

use Zend\Authentication\AuthenticationService,
	Zend\ServiceManager\ServiceLocatorAwareInterface,
	Zend\ServiceManager\ServiceLocatorInterface,
	Zend\View\Helper\AbstractHelper;

class AuthService extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;
	
	public function __invoke()
	{
		return $this->getAuthService();
	}
	
	/**
	 * Set the service locator.
	 *
	 * @param  ServiceLocatorInterface $serviceLocator
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
	/**
	 * Get the service locator.
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
	/**
	 * Returns the application service manager
	 * 
	 * @return ServiceLocatorInterface
	 */
	public function getApplicationServiceLocator()
	{
		// View helpers implementing ServiceLocatorAwareInterface are given Zend\View\HelperPluginManager!
		return $this->getServiceLocator()->getServiceLocator();
	}
	
	/**
	 * Returns the authentication service used by the application
	 * 
	 * @return AuthenticationService
	 */
	public function getAuthService()
	{
		if (!$this->authService) {
			$this->authService = $this->getApplicationServiceLocator()->get('AuthService');
		}
		
		return $this->authService;
	}
	
}
