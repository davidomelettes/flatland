<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumModel;

class Thread extends QuantumModel
{
	/**
	 * @var Post
	 */
	protected $post;
	
	protected $propertyMap = array(
		'post' => 'post',
	);
	
	public function setPost($postData)
	{
		if (is_array($postData)) {
			$postData = new Post($postData);
		}
		if ($postData instanceof Post) {
			$this->post = $postData;
		} else {
			$this->post = null;
		}
		
		return $this;
	}
	
	public function getTableHeadings()
	{
		return array(
			'name'			=> 'Name',
			'created'		=> 'Date Started',
		);
	}
	
	public function getTableRowPartial()
	{
		return 'tabulate/thread';
	}
	
}
