<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumModel;

class Post extends QuantumModel
{
	protected $content;
	
	protected $threadKey;
	
	protected $propertyMap = array(
		'content' 	=> 'content',
		'threadKey'	=> 'thread_key',
	);
	
	public function getName()
	{
		$content = $this->getContent();
		if (is_string($content)) {
			$content = substr($this->getContent(), 0, 32);
		}
		return $content;
	}
	
}
