<?php

namespace Core;

class Collection {

	protected $_objects = [];

	public function __construct($array)
	{
		$this->_objects = $array;
	}

	public function getCollection()
	{
		return $this->_objects;
	}

	public function getData()
	{
		$data = [];
		foreach ($this->_objects as $object) {
			$data[] = $object->getValues();
		}

		return $data;
	}

	public function getHashMap($key, $value) {
		$data = [];

		foreach ($this->_objects as $object) {
			$name = $object->getValue($key);
			$data[$name] = $object->getValue($value);
		}

		return $data;
	}

	public function getValues($field)
	{
		$data = [];
		foreach ($this->_objects as $object) {
			$data[] = $object->getValue($field);
		}

		return $data;
	}

	public function getCount()
	{
		return count($this->_objects);
	}

	public function isEmpty()
	{
		return empty($this->_objects);
	}
}
