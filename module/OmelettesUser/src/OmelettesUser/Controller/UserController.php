<?php

namespace OmelettesUser\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesUser\Form,
	OmelettesUser\Model\UserMapper;

class UserController extends AbstractController
{
	/**
	 * @var Form\ChangePasswordFilter
	 */
	protected $changePasswordFilter;
	
	/**
	 * @var Form\ChangePasswordForm
	 */
	protected $changePasswordForm;
	
	/**
	 * @var Form\UserInfoFilter
	 */
	protected $userInfoFilter;
	
	/**
	 * @var Form\UserInfoForm
	 */
	protected $userInfoForm;
	
	/**
	 * @var UserMapper
	 */
	protected $userMapper;
	
	public function getChangePasswordFilter()
	{
		if (!$this->changePasswordFilter) {
			$changePasswordFilter = $this->getServiceLocator()->get('OmelettesUser\Form\ChangePasswordFilter');
			$this->changePasswordFilter = $changePasswordFilter;
		}
		
		return $this->changePasswordFilter;
	}
	
	public function getChangePasswordForm()
	{
		if (!$this->changePasswordForm) {
			$changePasswordForm = new Form\ChangePasswordForm();
			$this->changePasswordForm = $changePasswordForm;
		}
		
		return $this->changePasswordForm;
	}
	
	public function getUserInfoFilter()
	{
		if (!$this->userInfoFilter) {
			$filter = new Form\UserInfoFilter();
			$this->userInfoFilter = $filter;
		}
	
		return $this->userInfoFilter;
	}
	
	public function getUserInfoForm()
	{
		if (!$this->userInfoForm) {
			// Must fetch via the FormElementManager so that registered form_elements have been initialised
			$form = $this->getServiceLocator()->get('FormElementManager')->get('OmelettesUser\Form\UserInfoForm');
			$form->get('password')->setChangeUrl($this->url()->fromRoute('user', array('action'=>'change-password')));
			$form->get('name')->setChangeUrl($this->url()->fromRoute('user', array('action'=>'change-email-address')));
			$this->userInfoForm = $form;
		}
		
		return $this->userInfoForm;
	}
	
	public function getUserMapper()
	{
		if (!$this->userMapper) {
			$userMapper = $this->getServiceLocator()->get('OmelettesUser\Model\UserMapper');
			$this->userMapper = $userMapper;
		}
		
		return $this->userMapper;
	}
	
	public function infoAction()
	{
		$form = $this->getUserInfoForm();
		$identity = $this->getAuthService()->getIdentity();
		// We don't want to write to the auth identity
		$user = clone $identity;
		$form->bind($user);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($this->getUserInfoFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$user->key = $identity->key;
				$this->getUserMapper()->updateUser($user);
				$this->getLocalesMapper()->updateForUser($user, $form->getInputFilter()->getValue('secondary_locales'));
				
				$this->flashMessenger()->addSuccessMessage('User information updated');
				
				// The new identity is only written to the auth storage during the route phase
				// So, we'll need to re-dispatch otherwise this page will render with the old details
				return $this->redirect()->toRoute('user');
			}
		}
		
		return array(
			'form' => $form,
		);
	}
	
	public function preferencesAction()
	{
		return array();
	}
	
	public function changePasswordAction()
	{
		$changePasswordForm = $this->getChangePasswordForm();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$changePasswordForm->setInputFilter($this->getChangePasswordFilter()->getInputFilter());
			$changePasswordForm->setData($request->getPost());
			if ($changePasswordForm->isValid()) {
				$this->getUserMapper()->updatePassword($this->getAuthService()->getIdentity(), $changePasswordForm->getInputFilter()->getValue('password_new'));
				$this->getAuthService()->getIdentity()->setPasswordAuthenticated();
				$this->flashMessenger()->addSuccessMessage('Your password has been updated');
				return $this->redirect()->toRoute('user');
			}
		}
		
		return array(
			'form'      => $changePasswordForm,
		);
	}
	
	public function changeEmailAddressAction()
	{
		return array();
	}
	
}
