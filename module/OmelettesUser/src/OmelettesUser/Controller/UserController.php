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
			$form = $this->getServiceLocator()->get('FormElementManager')->get('OmelettesUser\Form\UserInfoForm');
			$localesMapper = $this->getServiceLocator()->get('OmelettesLocale\Model\LocalesMapper');
			$options = array();
			foreach ($localesMapper->fetchAll() as $locale) {
				$options[$locale->code] = $locale->name;
			}
			$form->addLocaleElement($options);
			$form->addSubmitElement();
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
