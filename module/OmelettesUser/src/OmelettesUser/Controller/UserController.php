<?php

namespace OmelettesUser\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesUser\Form,
	OmelettesUser\Model\UserMapper;

class UserController extends AbstractController
{
	/**
	 * @var Form\UserInfoForm
	 */
	protected $userInfoForm;
	
	/**
	 * @var Form\UserInfoFilter
	 */
	protected $userInfoFilter;
	
	/**
	 * @var UserMapper
	 */
	protected $userMapper;
	
	public function getUserInfoForm()
	{
		if (!$this->userInfoForm) {
			// Must fetch via the FormElementManager so that registered form_elements have been initialised
			$form = $this->getServiceLocator()->get('FormElementManager')->get('OmelettesUser\Form\UserInfoForm');
			$this->userInfoForm = $form;
		}
		
		return $this->userInfoForm;
	}
	
	public function getUserInfoFilter()
	{
		if (!$this->userInfoFilter) {
			$filter = new Form\UserInfoFilter();
			$this->userInfoFilter = $filter;
		}
		
		return $this->userInfoFilter;
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
				$this->flashMessenger()->addSuccessMessage('User information updated');
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
	
}
