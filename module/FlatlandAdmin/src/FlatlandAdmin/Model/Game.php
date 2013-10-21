<?php

namespace FlatlandAdmin\Model;

use Omelettes\Model\QuantumModel;

class Game extends QuantumModel
{
	protected $propertyMap = array();
	
	/**
	 * @var GameVariant
	 */
	protected $variant;
	
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
		
		if (!$this->variant) {
			$variant = new GameVariant();
			$this->variant = $variant;
		}
		$this->variant->exchangeArray(isset($data['variant']) ? $data['variant'] : array());
	
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
			'variant'	=> $this->variant->getArrayCopy(),
		));
	}
	
	public function setVariant(GameVariant $variant)
	{
		$this->variant = $variant;
		
		return $this;
	}
	
	public function getVariant()
	{
		return $this->variant;
	}
	
}
