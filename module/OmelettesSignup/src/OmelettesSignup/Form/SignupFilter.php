<?php

namespace OmelettesSignup\Form;

use Omelettes\Form\QuantumFilter,
	Omelettes\Validator\Model\ModelDoesNotExist,
	Omelettes\Validator\Model\ModelExists,
	Omelettes\Validator\Uuid\V4 as UuidValidator;
use OmelettesSignup\Model\InvitationCodesMapper,
	OmelettesSignup\Model\UsersMapper as SignupUsersMapper;
use Zend\Validator\EmailAddress;

class SignupFilter extends QuantumFilter
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
				'name'			=> 'full_name',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array(
							'encoding'	=> 'UTF-8',
							'min'		=> 1,
							'max'		=> 255,
						),
					),
				),
			)));
			
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
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'password',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array(
							'encoding'	=> 'UTF-8',
							'min'		=> 6,
							'max'		=> 255,
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'invitation_code',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'						=> 'Omelettes\Validator\Uuid\V4',
						'break_chain_on_failure'	=> true,
						'options'					=> array(
							'messages'	=> array(
								UuidValidator::NOT_MATCH => 'Invalid invitation code',
							),
						),
					),
					array(
						'name'		=> 'Omelettes\Validator\Model\ModelExists',
						'options'	=> array(
							'mapper'	=> $this->invitationCodesMapper,
							'method'	=> 'find',
							'messages'	=> array(
								ModelExists::ERROR_MODEL_DOES_NOT_EXIST => 'Invitation code not found',
							),
						),
					),
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
