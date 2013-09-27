<?php

namespace OmelettesSignup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Signup\Form\SignupForm;

class SignupController extends AbstractActionController
{
	/**
	 * @var SignupForm
	 */
	protected $signupForm;
	
	public function getSignupForm()
	{
		if (!$this->signupForm) {
			$form = new SignupForm();
			$this->signupForm = $form;
		}
		
		return $this->signupForm;
	}
	
	public function signupAction()
	{
		$form = $this->getSignupForm();
		
		return array(
			'form' => $form,
		);
	}
	
}
