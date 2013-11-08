<?php

namespace FlatlandAdmin\Form;

use Omelettes\Form\AbstractQuantumModelFilter,
	Omelettes\Validator\Model\ModelDoesNotExist;
use OmelettesSignup\Model\InvitationCodesMapper,
	OmelettesSignup\Model\UsersMapper as SignupUsersMapper;
use Zend\Validator\EmailAddress;

class InviteUserFilter extends AbstractQuantumModelFilter
{
	/**
	 * @var SignupUsersMapper
	 */
	protected $usersMapper;
	
	/**
	 * @var InvitationCodesMapper
	 */
	protected $invitationCodesMapper;
	
	public function __construct(SignupUsersMapper $usersMapper, InvitationCodesMapper $invitationCodesMapper)
	{
		$this->usersMapper = $usersMapper;
		$this->invitationCodesMapper = $invitationCodesMapper;
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = parent::getInputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'name',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'EmailAddress',
						'options'	=> array(
							'messages'	=> array(
								EmailAddress::INVALID_FORMAT => 'Please enter a valid email address',
							),
						),
					),
					array(
						'name'		=> 'Omelettes\Validator\Model\ModelDoesNotExist',
						'options'	=> array(
							'mapper'	=> $this->usersMapper,
							'method'	=> 'findByName',
							'messages'	=> array(
								ModelDoesNotExist::ERROR_MODEL_EXISTS => 'A user with that email address already exists',
							),
						),
					),
					array(
						'name'		=> 'Omelettes\Validator\Model\ModelDoesNotExist',
						'options'	=> array(
							'mapper'	=> $this->invitationCodesMapper,
							'method'	=> 'findByName',
							'messages'	=> array(
								ModelDoesNotExist::ERROR_MODEL_EXISTS => 'That user has already been invited',
							),
						),
					),
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $inputFilter;
	}
	
}
