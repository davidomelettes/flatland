<?php

namespace FlatlandForum\Model;

use Omelettes\Model\QuantumModel;

class Thread extends QuantumModel
{
	protected $slug;
	
	protected $forumKey;
	
	protected $gameKey;
	
	protected $groupKey;
	
	/**
	 * @var Post
	 */
	protected $post;
	
	protected $propertyMap = array(
		'slug'		=> 'slug',
		'forumKey'	=> 'forum_key',
		'gameKey'	=> 'game_key',
		'groupKey'	=> 'group_key',
		'post'		=> 'post',
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
