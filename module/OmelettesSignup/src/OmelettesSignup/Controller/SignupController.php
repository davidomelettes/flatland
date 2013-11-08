<?php

namespace OmelettesSignup\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesAuth\Model\User as SignupUser;
use OmelettesSignup\Form,
OmelettesSignup\Model\InvitationCodesMapper,
	OmelettesSignup\Model\UsersMapper as SignupUsersMapper;
use Zend\Form\FormInterface,
	Zend\Mvc\Controller\AbstractActionController;

class SignupController extends AbstractController
{
	/**
	 * @var Form\SignupForm
	 */
	protected $signupForm;
	
	/**
	 * @var Form\SignupFilter
	 */
	protected $signupFilter;
	
	/**
	 * @var SignupUsersMapper
	 */
	protected $usersMapper;
	
	/**
	 * @var InvitationCodesMapper
	 */
	protected $invitationCodesMapper;
	
	public function getSignupForm()
	{
		if (!$this->signupForm) {
			$form = new Form\SignupForm();
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
	
	public function getInvitationCodesMapper()
	{
		if (!$this->invitationCodesMapper) {
			$mapper = $this->getServiceLocator()->get('OmelettesSignup\Model\InvitationCodesMapper');
			$this->invitationCodesMapper = $mapper;
		}
		
		return $this->invitationCodesMapper;
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
		
		$prePopulate = array('email' => 'name', 'name' => 'full_name', 'code' => 'invitation_code');
		foreach ($prePopulate as $param => $input) {
			$form->get($input)->setValue($this->params()->fromQuery($param));
		}
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getSignupFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$formData = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$this->getUsersMapper()->beginTransaction();
				try {
					// Remove invitation
					$this->getInvitationCodesMapper()->deleteInvitation($formData['invitation_code']);
					
					// Create account
					$this->getUsersMapper()->signupUser($user, $formData['password']);
					
					// Log in
					$user->setPasswordAuthenticated();
					$this->getAuthService()->getStorage()->write($user);
					
				} catch (Exception $e) {
					$this->getAuthService()->clearIdentity();
					$this->getUsersMapper()->rollbackTransaction();
					$this->flashMessenger('A problem occurred during the sign up process, please try again');
					return $this->redirect('signup');
				}
				$this->getUsersMapper()->commitTransaction();
				
				return $this->redirect()->toRoute('home');
			}
		}
		
		return array(
			'form' => $form,
		);
	}
	
}
