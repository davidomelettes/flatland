<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form;
use Omelettes\Controller\AbstractController;
use OmelettesAuth\Model\User as SignupUser;
use OmelettesSignup\Model\InvitationCode,
	OmelettesSignup\Model\InvitationCodesMapper,
	OmelettesSignup\Model\UsersMapper;

class UsersController extends AbstractController
{
	/**
	 * @var UsersMapper
	 */
	protected $usersMapper;
	
	/**
	 * @var Form\AddUserForm
	 */
	protected $addUserForm;
	
	/**
	 * @var Form\AddUserFilter
	 */
	protected $addUserFilter;
	
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
	
	public function getUsersMapper()
	{
		if (!$this->usersMapper) {
			$usersMapper = $this->getServiceLocator()->get('OmelettesSignup\Model\UsersMapper');
			$this->usersMapper = $usersMapper;
		}
		
		return $this->usersMapper;
	}
	
	public function getAddUserForm()
	{
		if (!$this->addUserForm) {
			$form = new Form\AddUserForm();
			$this->addUserForm = $form;
		}
		
		return $this->addUserForm;
	}
	
	public function getAddUserFilter()
	{
		if (!$this->addUserFilter) {
			$filter = $this->getServiceLocator()->get('FlatlandAdmin\Form\AddUserFilter');
			$this->addUserFilter = $filter;
		}
		
		return $this->addUserFilter;
	}
	
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
	
	public function indexAction()
	{
		$paginator = $this->getUsersMapper()->fetchAll(true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		
		return array(
			'users' => $paginator,
		);
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
				$this->getInvitationCodesMapper()->saveInvitation($code);
				
				// Send invitation
				$this->sendInvitationEmail($code);
		
				return $this->redirect()->toRoute('admin/users');
			}
		}
		
		return array(
			'form'		=> $form,
			'invites'	=> $this->getInvitationCodesMapper()->fetchAll(true),
		);
	}
	
}
