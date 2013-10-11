<?php

namespace FlatlandGame\Controller;

use FlatlandGame\Form;
use Omelettes\Controller\AbstractController;

class GamesController extends AbstractController
{
	/**
	 * @var Form\GameForm
	 */
	protected $gameForm;
	
	public function getGameForm()
	{
		if (!$this->gameForm) {
			$form = $this->getServiceLocator()->get('FormElementManager')->get('FlatlandGame\Form\GameForm');
			$this->gameForm = $form;
		}
		
		return $this->gameForm;
	}
	
	public function indexAction()
	{
		return array();
	}
	
	public function addAction()
	{
		$form = $this->getGameForm();
		
		return array(
			'form' => $form,
		);
	}
	
	public function viewAction()
	{
		return array();
	}
	
}
