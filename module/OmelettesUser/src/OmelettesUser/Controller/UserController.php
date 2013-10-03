<?php

namespace OmelettesUser\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesUser\Form\UserInfoForm;

class UserController extends AbstractController
{
	/**
	 * @var UserInfoForm
	 */
	protected $userInfoForm;
	
	public function getUserInfoForm()
	{
		if (!$this->userInfoForm) {
			// Must fetch via the FormElementManager so that registered form_elements have been initialised
			$form = $this->getServiceLocator()->get('FormElementManager')->get('OmelettesUser\Form\UserInfoForm');
			$this->userInfoForm = $form;
		}
		
		return $this->userInfoForm;
	}
	
	public function infoAction()
	{
		$form = $this->getUserInfoForm();
		$form->bind($this->getAuthService()->getIdentity());
		
		return array(
			'form' => $form,
		);
	}
	
	public function preferencesAction()
	{
		return array();
	}
	
}
