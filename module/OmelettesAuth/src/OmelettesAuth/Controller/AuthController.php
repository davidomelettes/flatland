<?php

namespace OmelettesAuth\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesAuth\Form\ForgotPasswordFilter;
use OmelettesAuth\Form\ForgotPasswordForm;
use OmelettesAuth\Form\LoginFilter;
use OmelettesAuth\Form\LoginForm;
use OmelettesAuth\Form\ResetPasswordFilter;
use OmelettesAuth\Form\ResetPasswordForm;
use OmelettesAuth\Model\User;
use OmelettesAuth\Model\UsersMapper;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class AuthController extends AbstractController
{
	/**
	 * @var ForgotPasswordForm
	 */
	protected $forgotPasswordForm;
	
	/**
	 * @var ForgotPasswordFilter
	 */
	protected $forgotPasswordFilter;
	
	/**
	 * @var LoginForm
	 */
	protected $loginForm;
	
	/**
	 * @var LoginFilter
	 */
	protected $loginFilter;
	
	/**
	 * @var ResetPasswordForm
	 */
	protected $resetPasswordForm;
	
	/**
	 * @var ResetPasswordFilter
	 */
	protected $resetPasswordFilter;
	
	/**
	 * @var UsersMapper
	 */
	protected $usersMapper;
	
	public function getForgotPasswordForm()
	{
		if (!$this->forgotPasswordForm) {
			$this->forgotPasswordForm = new ForgotPasswordForm();
		}
	
		return $this->forgotPasswordForm;
	}
	
	public function getforgotPasswordFilter()
	{
		if (!$this->forgotPasswordFilter) {
			$forgotPasswordFilter = $this->getServiceLocator()->get('OmelettesAuth\Form\ForgotPasswordFilter');
			$this->forgotPasswordFilter = $forgotPasswordFilter;
		}
	
		return $this->forgotPasswordFilter;
	}
	
	public function forgotPasswordAction()
	{
		if ($this->getAuthService()->hasIdentity()) {
			// Already logged in
			$this->flashMessenger()->addSuccessMessage('You are already logged in');
			return $this->redirect()->toRoute('home');
		}
		
		$form = $this->getForgotPasswordForm();
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getForgotPasswordFilter()->getInputFilter());
			$form->setData($request->getPost());
				
			if ($form->isValid()) {
				$emailAddress = $form->getInputFilter()->getValue('name');
				$user = $this->getUsersMapper()->findByName($emailAddress);
				$passwordResetKey = $this->getUsersMapper()->regeneratePasswordResetKey($user);
				$this->sendForgotPasswordEmail($emailAddress, $passwordResetKey);
				$this->flashMessenger()->addSuccessMessage("Instructions for resetting your password have been sent to $emailAddress");
			}
		}
		
		return array(
			'form'		=> $form,
		);
	}
	
	public function sendForgotPasswordEmail($emailAddress, $passwordResetKey)
	{
		if (false === ($user = $this->getUsersMapper()->findByName($emailAddress))) {
			throw new \Exception('Failed to find user by name: ' . $emailAddress);
		}
		
		$variables = array(
			'user_key'				=> $user->key,
			'password_reset_key'	=> $passwordResetKey,
		);
		
		$mailer = $this->getServiceLocator()->get('Mailer');
		$mailer->setHtmlTemplate('mail/html/reset-password', $variables);
		$mailer->setTextTemplate('mail/text/reset-password', $variables);
		
		$mailer->send(
			'Subject Text',
			$emailAddress
		);
	}
	
	public function getLoginForm()
	{
		if (!$this->loginForm) {
			$loginForm = new LoginForm();
			$this->loginForm = $loginForm;
		}
		
		return $this->loginForm;
	}
	
	public function getLoginFilter()
	{
		if (!$this->loginFilter) {
			$loginFilter = $this->getServiceLocator()->get('OmelettesAuth\Form\LoginFilter');
			$this->loginFilter = $loginFilter;
		}
	
		return $this->loginFilter;
	}
	
	public function loginAction()
	{
		if ($this->getAuthService()->hasIdentity()) {
			// Already logged in
			$this->flashMessenger()->addSuccessMessage('You are already logged in');
			return $this->redirect()->toRoute('home');
		}
		$form = $this->getLoginForm();
		
		$request = $this->getRequest();
		$user = new User();
		$form->bind($user);
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getLoginFilter()->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$this->getAuthService()->getAdapter()
					->setIdentity($form->getInputFilter()->getValue('name'))
					->setCredential($form->getInputFilter()->getValue('password'));
				
				$result = $this->getAuthService()->authenticate();
				if ($result->isValid()) {
					$userIdentity = new User((array)$this->getAuthService()->getAdapter()->getResultRowObject());
					$this->getAuthService()->getStorage()->write($userIdentity);
					if ($request->getPost('remember_me')) {
						$this->getAuthService()->getStorage()->rememberMe();
					}
					$this->flashMessenger()->addSuccessMessage('Login successful');
					return $this->redirect()->toRoute('home');
				} else {
					$this->flashMessenger()->addErrorMessage('No user was found matching that email address and/or password');
				}
			}
		}
		
		return array(
			'form'      => $form,
		);
	}
	
	public function logoutAction()
	{
		$this->getAuthService()->clearIdentity();
		$this->getAuthService()->getStorage()->forgetMe();
			
		$this->flashMessenger()->addSuccessMessage('You have successfully logged out');
		return $this->redirect()->toRoute('login');
	}
	
	public function getResetPasswordForm()
	{
		if (!$this->resetPasswordForm) {
			$this->resetPasswordForm = new ResetPasswordForm();
		}
	
		return $this->resetPasswordForm;
	}
	
	public function getResetPasswordFilter()
	{
		if (!$this->resetPasswordFilter) {
			$resetPasswordFilter = new ResetPasswordFilter();
			$this->resetPasswordFilter = $resetPasswordFilter;
		}
	
		return $this->resetPasswordFilter;
	}
	
	public function resetPasswordAction()
	{
		if ($this->getAuthService()->hasIdentity()) {
			// Already logged in
			$this->flashMessenger()->addSuccessMessage('You are already logged in');
			return $this->redirect()->toRoute('home');
		}
		
		// Create a single-use authentication adapter for authorising against the password reset key
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$dbTableResetPasswordAuthAdapter = new DbTableAuthAdapter(
			$dbAdapter,
			'users',
			'key',
			'password_reset_key',
			"password_reset_requested IS NOT NULL AND password_reset_requested > (now() - interval '1 day') password_reset_key IS NOT NULL AND acl_role = 'user'"
		);
		$dbTableResetPasswordAuthAdapter->setIdentity($this->params('user_key'))
			->setCredential($this->params('password_reset_key'));
		$result = $dbTableResetPasswordAuthAdapter->authenticate();
		if (!$result->isValid()) {
			$this->flashMessenger()->addErrorMessage('Invalid user and/or password reset key');
			return $this->redirect()->toRoute('login');
		}
		$passwordResetUser = new User((array)$dbTableResetPasswordAuthAdapter->getResultRowObject());
		
		// User has verified password reset key, allow form to be displayed
		$form = $this->getResetPasswordForm();
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getResetPasswordFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				// We can now change the password
				$this->getUsersMapper()->updatePassword($passwordResetUser, $form->getInputFilter()->getValue('password_new'));
				$this->flashMessenger()->addSuccessMessage('Your password has been updated');
				return $this->redirect()->toRoute('login');
			}
		}
		
		return array(
			'form'					=> $form,
			'user_key'				=> $passwordResetUser->key,
			'password_reset_key'	=> $this->params('password_reset_key'),
		);
	}
	
	public function getUsersMapper()
	{
		if (!$this->usersMapper) {
			$usersMapper = $this->getServiceLocator()->get('OmelettesAuth\Model\UsersMapper');
			$this->usersMapper = $usersMapper;
		}
		
		return $this->usersMapper;
	}
	
}
