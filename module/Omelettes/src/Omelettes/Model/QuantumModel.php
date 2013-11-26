<?php

namespace Omelettes\Model;

use Omelettes\Model\AbstractModel;
use OmelettesAuth\Model\User;

class QuantumModel extends AbstractModel implements Tabulatable, \JsonSerializable
{
	/**
	 * @var array
	 */
	protected $propertyMap;

	/**
	 * Array of model properties => database columns
	 *
	 * @var array
	 */
	protected $quantumPropertyMap = array(
		'key'				=> 'key',
		'name'				=> 'name',
		'created'			=> 'created',
		'updated'			=> 'updated',
		'createdBy'			=> 'created_by',
		'updatedBy'			=> 'updated_by',
	);

	protected $key;
	protected $name;
	protected $created;
	protected $updated;
	protected $createdBy;
	protected $updatedBy;

	public function __construct($data = array())
	{
		if (!is_array($this->propertyMap)) {
			throw new \Exception(get_class($this) . ' has missing property map');
		}

		if (!empty($data)) {
			$this->exchangeArray($data);
		}
	}

	public function __get($name)
	{
		$getterMethodName = 'get' . ucfirst($name);
		if (!method_exists($this, $getterMethodName) && !isset($this->quantumPropertyMap[$name]) && !isset($this->propertyMap[$name])) {
			throw new \Exception('Invalid ' . get_class($this) . ' property: ' . $name);
		}

		return $this->$getterMethodName();
	}

	public function __set($name, $value)
	{
		$setterMethodName = 'set' . ucfirst($name);
		if (!method_exists($this, $setterMethodName) && !isset($this->quantumPropertyMap[$name]) && !isset($this->propertyMap[$name])) {
			throw new \Exception('Invalid ' . get_class($this) . ' property: ' . $name);
		}

		return $this->$setterMethodName($value);
	}

	public function __call($function, array $args)
	{
		if (preg_match('/(get|set)(.+)/', $function, $m)) {
			$property = lcfirst($m[2]);
			if (isset($this->quantumPropertyMap[$property]) || isset($this->propertyMap[$property])) {
				if ('get' === $m[1]) {
					// Getting a model property
					return $this->$property;
				} else {
					// Setting a model property
					$this->$property = $args[0];
						
					return $this;
				}
			}
		}
	}

	public function jsonSerialize()
	{
		return $this->getArrayCopy();
	}

	public function exchangeArray($data)
	{
		foreach ($this->quantumPropertyMap as $property => $column) {
			$setterMethodName = 'set'.ucfirst($property);
			$this->$setterMethodName(isset($data[$column]) ? $data[$column] : null);
		}
		foreach ($this->propertyMap as $property => $column) {
			$setterMethodName = 'set'.ucfirst($property);
			$this->$setterMethodName(isset($data[$column]) ? $data[$column] : null);
		}

		return $this;
	}

	public function getArrayCopy()
	{
		$copy = array();
		foreach ($this->quantumPropertyMap as $property => $column) {
			$getterMethodName = 'get'.ucfirst($property);
			$copy[$column] = $this->$getterMethodName();
		}
		foreach ($this->propertyMap as $property => $column) {
			$getterMethodName = 'get'.ucfirst($property);
			$copy[$column] = $this->$getterMethodName();
		}

		return $copy;
	}

	public function setKey($key)
	{
		$this->key = (string)$key;

		return $this;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setCreated($ts)
	{
		$this->created = $ts;

		return $this;
	}

	public function getCreated()
	{
		return $this->created;
	}

	public function setUpdated($ts)
	{
		$this->updated = $ts;

		return $this;
	}

	public function getUpdated()
	{
		return $this->updated;
	}

	public function setCreatedBy($key)
	{
		$this->createdBy = $key;

		return $this;
	}

	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	public function setUpdatedBy($key)
	{
		$this->updatedBy = $key;

		return $this;
	}

	public function getUpdatedBy()
	{
		return $this->updatedBy;
	}

	public function getCreatedByFullName()
	{
		return $this->createdByFullName;
	}

	public function getUpdatedByFullName()
	{
		return $this->updatedByFullName;
	}

	public function getTableHeadings()
	{
		return array(
			'name'	=> 'Name',
		);
	}

	public function getTableRowPartial()
	{
		return 'tabulate/quantum';
	}

}
