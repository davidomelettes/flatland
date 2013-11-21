<?php

namespace OmelettesAuth\View\Helper;

use Zend\Permissions\Acl,
	Zend\ServiceManager\ServiceLocatorAwareInterface,
	Zend\ServiceManager\ServiceLocatorAwareTrait,
	Zend\View\Helper\AbstractHelper;

class AclService extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	use ServiceLocatorAwareTrait;
	
	/**
	 * @var Acl\Acl
	 */
	protected $aclService;
	
	public function __invoke()
	{
		return $this->getAclService();
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
	 * @return Acl\Acl
	 */
	public function getAclService()
	{
		if (!$this->aclService) {
			$this->aclService = $this->getApplicationServiceLocator()->get('AclService');
		}
		
		return $this->aclService;
	}
	
}
