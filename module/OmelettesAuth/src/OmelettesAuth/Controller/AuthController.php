<?php

namespace OmelettesAuth\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesAuth\Form,
	OmelettesAuth\Model\User,
	OmelettesAuth\Model\UserLoginsMapper,
	OmelettesAuth\Model\UsersMapper;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter,
	Zend\Http\Header\SetCookie;

class AuthController extends AbstractController
{
	/**
	 * @var Form\ForgotPasswordForm
	 */
	protected $forgotPasswordForm;
	
	/**
	 * @var Form\ForgotPasswordFilter
	 */
	protected $forgotPasswordFilter;
	
	/**
	 * @var Form\LoginForm
	 */
	protected $loginForm;
	
	/**
	 * @var Form\LoginFilter
	 */
	protected $loginFilter;
	
	/**
	 * @var Form\ResetPasswordForm
	 */
	protected $resetPasswordForm;
	
	/**
	 * @var Form\ResetPasswordFilter
	 */
	protected $resetPasswordFilter;
	
	/**
	 * @var UserLoginsMapper
	 */
	protected $userLoginsMapper;
	
	/**
	 * @var UsersMapper
	 */
	protected $usersMapper;
	
	public function getForgotPasswordForm()
	{
		if (!$this->forgotPasswordForm) {
			$this->forgotPasswordForm = new Form\ForgotPasswordForm();
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
			$loginForm = new Form\LoginForm();
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
	
	protected function rememberMe()
	{
		if (!$this->getAuthService()->hasIdentity()) {
			throw new \Exception('Expected an identity');
		}
		$user = $this->getAuthService()->getIdentity();
		$setCookieHeader = new SetCookie(
			'login',
			$this->getUserLoginsMapper()->saveLogin($user->name),
			(int)date('U', strtotime('+2 weeks'))
		);
		$this->getResponse()->getHeaders()->addHeader($setCookieHeader);
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
					
					// We've just authenticated with a password
					$userIdentity->setPasswordAuthenticated();
					$this->getAuthService()->getStorage()->write($userIdentity);
					if ($request->getPost('remember_me')) {
						$this->rememberMe();
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
	
	protected function unrememberMe()
	{
		$cookie = $this->getRequest()->getCookie();
		if ($cookie && $cookie->offsetExists('login')) {
			$data = $this->getUserLoginsMapper()->splitCookieData($cookie->login);
			$name = $this->getAuthService()->getIdentity()->name;
			$this->getUserLoginsMapper()->deleteForNameWithSeries($name, $data['series']);
			// Remove the login cookie
			$setCookieHeader = new SetCookie(
				'login',
				'',
				(int)date('U', strtotime('-2 weeks'))
			);
			$this->getResponse()->getHeaders()->addHeader($setCookieHeader);
		}
	}
	
	public function logoutAction()
	{
		if ($this->getAuthService()->hasIdentity()) {
			$user = $this->getAuthService()->getIdentity();
			$this->unrememberMe();
			$this->getAuthService()->clearIdentity();
		}
			
		$this->flashMessenger()->addSuccessMessage('You have successfully logged out');
		return $this->redirect()->toRoute('login');
	}
	
	public function getResetPasswordForm()
	{
		if (!$this->resetPasswordForm) {
			$this->resetPasswordForm = new Form\ResetPasswordForm();
		}
	
		return $this->resetPasswordForm;
	}
	
	public function getResetPasswordFilter()
	{
		if (!$this->resetPasswordFilter) {
			$resetPasswordFilter = new Form\ResetPasswordFilter();
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
			"password_reset_requested IS NOT NULL AND password_reset_requested > (now() - interval '1 day') password_reset_key IS NOT NULL AND acl_role != 'system'"
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
	
	public function getUserLoginsMapper()
	{
		if (!$this->userLoginsMapper) {
			$userLoginsMapper = $this->getServiceLocator()->get('OmelettesAuth\Model\UserLoginsMapper');
			$this->userLoginsMapper = $userLoginsMapper;
		}
		
		return $this->userLoginsMapper;
	}
	
	public function getUsersMapper()
	{
		if (!$this->usersMapper) {
			$usersMapper = $this->getServiceLocator()->get('OmelettesAuth\Model\UsersMapper');
			$this->usersMapper = $usersMapper;
		}
		
		return $this->usersMapper;
	}
	
	public function loginTheftWarningAction()
	{
		return array();
	}
	
}
