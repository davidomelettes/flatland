<?php

namespace Omelettes\Controller;

use Omelettes\Form;
use Omelettes\Model;
use OmelettesAuth\Authentication\AuthenticationService;
use OmelettesLocale\Model\LocalesMapper;
use Zend\Log\Logger,
	Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
	/**
	 * @var LocalesMapper
	 */
	protected $localesMapper;
	
	/**
	 * @var Logger
	 */
	protected $logger;
	
	/**
	 * @var Form\ConfirmDeleteForm
	 */
	protected $confirmDeleteForm;
	
	public function getAuthService()
	{
		if (!$this->authService) {
			$authService = $this->getServiceLocator()->get('AuthService');
			$this->authService = $authService;
		}
		
		return $this->authService;
	}
	
	public function getLocalesMapper()
	{
		if (!$this->localesMapper) {
			$localesMapper = $this->getServiceLocator()->get('OmelettesLocale\Model\LocalesMapper');
			$this->localesMapper = $localesMapper;
		}
		
		return $this->localesMapper;
	}
	
	public function getLogger()
	{
		if (!$this->logger) {
			$logger = $this->getServiceLocator()->get('Omelettes/Logger');
			$this->logger = $logger;
		}
		
		return $this->logger;
	}
	
	public function getConfirmDeleteForm($model = null, $route = null, $routeOptions = array())
	{
		if (!$this->confirmDeleteForm) {
			$form = new Form\ConfirmDeleteForm();
			if ($model instanceof Model\QuantumModel) {
				$submitFieldset = $form->get('submit');
				$submitFieldset->add(array(
					'name'		=> 'cancel',
					'type'		=> 'Omelettes\Form\Element\Url',
					'attributes'=> array(
						'value'		=> 'Cancel',
					),
					'options' => array(
						'route' => $route,
						'route_options' => $routeOptions,
						'anchor_class' => 'btn btn-default',
					),
				));
			}
			$this->confirmDeleteForm = $form;
		}
		
		return $this->confirmDeleteForm;
	}
	
}
