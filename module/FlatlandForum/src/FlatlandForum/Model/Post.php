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
		
		// Fudge to allow reuse of the post fieldset
		'post'		=> 'post',
	);
	
	public function getName()
	{
		$content = $this->getContent();
		if (is_string($content)) {
			$content = substr($this->getContent(), 0, 32);
		}
		return $content;
	}
	
	public function setPost($postData)
	{
		if (!is_array($postData)) {
			return $this;
		}
		
		// Prevent infinite loops
		unset($postData['post']);
		
		// Exchange using this subset instead
		return $this->exchangeArray($postData);
	}
	
	public function getPost()
	{
		return null;
	}
	
	public function getTableHeadings()
	{
		return array(
			'who'			=> 'Who',
			'what'			=> 'What',
		);
	}
	
	public function getTableRowPartial()
	{
		return 'tabulate/post';
	}
	
}
