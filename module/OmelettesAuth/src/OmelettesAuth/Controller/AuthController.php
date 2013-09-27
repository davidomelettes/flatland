<?php

namespace OmelettesAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use OmelettesAuth\Form\LoginForm;

class AuthController extends AbstractActionController
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
	/**
	 * @var LoginForm
	 */
	protected $loginForm;
	
	public function getAuthService()
	{
		if (!$this->authService) {
			$authService = $this->getServiceLocator()->get('AuthService');
			$this->authService = $authService;
		}
		
		return $this->authService;
	}
	
	public function getLoginForm()
	{
		if (!$this->loginForm) {
			$loginForm = new LoginForm();
			$this->loginForm = $loginForm;
		}
		
		return $this->loginForm;
	}
	
	public function loginAction()
	{
		$loginForm = $this->getLoginForm();
		
		return array(
			'form' => $loginForm,
		);
	}
	
	public function logoutAction()
	{
		$this->getAuthService()->clearIdentity();
		$this->getAuthService()->getStorage()->forgetMe();
			
		$this->flashMessenger()->addSuccessMessage('You have successfully logged out');
		return $this->redirect()->toRoute('login');
	}
	
}
