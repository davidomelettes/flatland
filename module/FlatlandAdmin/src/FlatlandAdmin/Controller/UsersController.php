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
	
	/**
	 * @var InvitationCodesMapper
	 */
	protected $invitationCodesMapper;
	
	/**
	 * @var Form\InviteUserForm
	 */
	protected $inviteUserForm;
	
	/**
	 * @var Form\InviteUserFilter
	 */
	protected $inviteUserFilter;
	
	public function getInvitationCodesMapper()
	{
		if (!$this->invitationCodesMapper) {
			$mapper = $this->getServiceLocator()->get('OmelettesSignup\Model\InvitationCodesMapper');
			$this->invitationCodesMapper = $mapper;
		}
		
		return $this->invitationCodesMapper;
	}
	
	public function getInviteUserForm()
	{
		if (!$this->inviteUserForm) {
			$form = new Form\InviteUserForm();
			$this->inviteUserForm = $form;
		}
	
		return $this->inviteUserForm;
	}
	
	public function getInviteUserFilter()
	{
		if (!$this->inviteUserFilter) {
			$filter = $this->getServiceLocator()->get('FlatlandAdmin\Form\InviteUserFilter');
			$this->inviteUserFilter = $filter;
		}
	
		return $this->inviteUserFilter;
	}
	
	public function addAction()
	{
		$form = $this->getAddUserForm();
		$request = $this->getRequest();
		$user = new SignupUser();
		$form->bind($user);
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getAddUserFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				// Create account
				$this->getUsersMapper()->signupUser($user, $request->getPost('password'));
				
				return $this->redirect()->toRoute('admin/users');
			}
		}
		
		return array(
			'form' => $form,
		);
	}
	
	public function sendInvitationEmail(InvitationCode $code)
	{
		if (!$this->getInvitationCodesMapper()->findByName($code->name)) {
			throw new \Exception('Failed to find invitation code for name: ' . $code->name);
		}
	
		$variables = array(
			'email_address'	=> $code->name,
			'full_name'		=> $code->fullName,
			'code'			=> $code->key,
		);
	
		$mailer = $this->getServiceLocator()->get('Mailer');
		$mailer->setHtmlTemplate('mail/html/invitation', $variables);
		$mailer->setTextTemplate('mail/text/invitation', $variables);
	
		$mailer->send(
			'You are invited to Flatland',
			$code->name
		);
	}
	
	public function inviteAction()
	{
		$form = $this->getInviteUserForm();
		$request = $this->getRequest();
		$code = new InvitationCode();
		$form->bind($code);
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getInviteUserFilter()->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$data = $form->getData();
				
				// Generate invitation code
				$this->getInvitationCodesMapper()->saveQuantum($code);
				
				// Send invitation
				$this->sendInvitationEmail($code);
		
				$this->flashMessenger()->addSuccessMessage('Invitation sent');
				return $this->redirect()->toRoute($this->getRouteName(), array('action' => 'invite'));
			}
		}
		
		return array(
			'form'		=> $form,
			'invites'	=> $this->getInvitationCodesMapper()->fetchAll(true),
		);
	}
	
	public function getIndexNavigationConfig()
	{
		$config = parent::getIndexNavigationConfig();
		$config[] = array(
			'label'			=> 'Invite',
			'route'			=> $this->getRouteName(),
			'routeOptions'	=> array('action' => 'invite'),
			'icon'			=> 'plus',
		);
		
		return $config;
	}
	
}
