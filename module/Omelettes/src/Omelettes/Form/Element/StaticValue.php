<?php

namespace Omelettes\Form\Element;

use Zend\Form\Element;

class StaticValue extends Element
{
	protected $escapeHtml = true;
	
	protected $attributes = array(
		'type' => 'static',
	);
	
	public function setOptions($options)
	{
		parent::setOptions($options);
		
		if (isset($options['escape_html'])) {
			$this->setEscapeHtml($options['escape_html']);
		}
		
		return $this;
	}
	
	public function setEscapeHtml($escape)
	{
		$this->escapeHtml = (boolean)$escape;
		
		return $this;
	}
	
	public function getEscapeHtml()
	{
		return $this->escapeHtml;
	}
	
}
