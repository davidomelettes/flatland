<?php

namespace FlatlandAdmin\Controller;

use FlatlandAdmin\Form,
	FlatlandAdmin\Model;
use Omelettes\Controller\QuantumController;
use OmelettesSignup\Model\InvitationCode,
	OmelettesSignup\Model\InvitationCodesMapper;

class InvitationsController extends QuantumController
{
	protected $addQuantumFilterClass = 'FlatlandAdmin\Form\InviteUserFilter';
	
	protected $addQuantumFormClass = 'FlatlandAdmin\Form\InviteUserForm';
	
	protected $editQuantumFilterClass = '';
	
	protected $editQuantumFormClass = '';
	
	protected $quantumMapperClass = 'OmelettesSignup\Model\InvitationCodesMapper';

	protected $quantumModelClass = 'OmelettesSignup\Model\InvitationCode';
	
	protected function sendInvitationEmail(InvitationCode $code)
	{
		if (!$this->getQuantumMapper()->findByName($code->name)) {
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
	
	public function indexAction()
	{
		$form = $this->getAddQuantumForm();
		$request = $this->getRequest();
		$code = new InvitationCode();
		$form->bind($code);
	
		if ($request->isPost()) {
			$form->setInputFilter($this->getAddQuantumFilter()->getInputFilter());
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$data = $form->getData();
	
				// Generate invitation code
				$this->getQuantumMapper()->saveQuantum($code);
	
				// Send invitation
				$this->sendInvitationEmail($code);
	
				$this->flashMessenger()->addSuccessMessage('Invitation sent');
				return $this->redirect()->toRoute($this->getRouteName(), array('action' => 'invite'));
			}
		}
	
		$paginator = $this->getQuantumMapper()->fetchAll(true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		
		return array(
			'form'		=> $form,
			'paginator'	=> $paginator,
		);
	}
	
}
