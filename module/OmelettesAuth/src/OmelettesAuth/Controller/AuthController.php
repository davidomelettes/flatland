<?php

namespace OmelettesAuth\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesAuth\Form\LoginForm;
use Zend\Authentication\AuthenticationService;

class AuthController extends AbstractActionController
{
	/**
	 * @var LoginForm
	 */
	protected $loginForm;
	
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
