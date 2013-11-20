<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form;
use Omelettes\Controller\QuantumController;
use OmelettesAuth\Model\User as SignupUser;
use OmelettesSignup\Model\InvitationCode,
	OmelettesSignup\Model\InvitationCodesMapper;

class UsersController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandAdmin\Form\AddUserFilter';
	
	protected $addQuantumFormClass = 'FlatlandAdmin\Form\AddUserForm';
	
	protected $editQuantumFilterClass = 'FlatlandAdmin\Form\AddUserFilter';
	
	protected $editQuantumFormClass = 'FlatlandAdmin\Form\AddUserForm';
	
	protected $quantumMapperClass = 'OmelettesSignup\Model\UsersMapper';
	
	protected $quantumModelClass = 'OmelettesAuth\Model\User';
	
	public function addAction()
	{
		$form = $this->getAddQuantumForm();
		$request = $this->getRequest();
		$user = new SignupUser();
		$form->bind($user);
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getAddQuantumFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				// Create account
				$this->getQuantumMapper()->signupUser($user, $request->getPost('password'));
				
				return $this->redirect()->toRoute('admin/users');
			}
		}
		
		return array(
			'form' => $form,
		);
	}
	
	public function getIndexNavigationConfig()
	{
		$config = parent::getIndexNavigationConfig();
		$config[] = array(
			'label'			=> 'Invite',
			'route'			=> 'admin/invites',
			'icon'			=> 'bullhorn',
		);
		
		return $config;
	}
	
}
