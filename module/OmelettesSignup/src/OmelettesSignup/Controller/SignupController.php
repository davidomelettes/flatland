<?php

namespace OmelettesSignup\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesAuth\Model\User as SignupUser;
use OmelettesSignup\Form\SignupForm;
use OmelettesSignup\Form\SignupFilter;
use OmelettesSignup\Model\UsersMapper as SignupUsersMapper;
use Zend\Mvc\Controller\AbstractActionController;

class SignupController extends AbstractController
{
	/**
	 * @var SignupForm
	 */
	protected $signupForm;
	
	/**
	 * @var SignupFilter
	 */
	protected $signupFilter;
	
	/**
	 * @var SignupUsersMapper
	 */
	protected $usersMapper;
	
	public function getSignupForm()
	{
		if (!$this->signupForm) {
			$form = new SignupForm();
			$this->signupForm = $form;
		}
		
		return $this->signupForm;
	}
	
	public function getSignupFilter()
	{
		if (!$this->signupFilter) {
			$userFilter = $this->getServiceLocator()->get('OmelettesSignup\Form\SignupFilter');
			$this->signupFilter = $userFilter;
		}
	
		return $this->signupFilter;
	}
	
	public function getUsersMapper()
	{
		if (!$this->usersMapper) {
			$usersMapper = $this->getServiceLocator()->get('OmelettesSignup\Model\UsersMapper');
			$this->usersMapper = $usersMapper;
		}
		
		return $this->usersMapper;
	}
	
	public function signupAction()
	{
		if ($this->getAuthService()->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('You are already logged in');
			return $this->redirect('home');
		}
		
		$form = $this->getSignupForm();
		$request = $this->getRequest();
		$user = new SignupUser();
		$form->bind($user);
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getSignupFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				// Create account
				$this->getUsersMapper()->signupUser($user, $request->getPost('password'));
				// Log in
				$this->getAuthService()->getStorage()->write($user);
				
				return $this->redirect()->toRoute('home');
			}
		}
		
		return array(
			'form' => $form,
		);
	}
	
}
