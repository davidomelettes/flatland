<?php

namespace FlatlandForum\Form;

use Zend\Form\Fieldset;

class PostFieldset extends Fieldset
{
	public function __construct($name = 'post', $options = array())
	{
		parent::__construct($name, $options);
		
		$this->add(array(
			'name'		=> 'content',
			'type'		=> 'Textarea',
			'options'	=> array(
				'label'		=> 'Content',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Content',
			),
		));
	}
	
}
