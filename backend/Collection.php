<?php

namespace Core;

use Core\Collection\Stream;

class Collection {

	protected $_objects = [];

	/**
	 * Sets objects array to collection
	 * @param $array
	 */
	public function __construct($array)
	{
		$this->_objects = $array;
	}

	/**
	 * Return array of objects
	 * @return array
	 */
	public function getCollection()
	{
		return $this->_objects;
	}

	/**
	 * Returns associative data map with keys of objects ids
	 * @return array
	 */
	public function getData()
	{
		$data = [];
		foreach ($this->_objects as $object) {
			$data[$object->getId()] = $object->getValues();
		}

		return $data;
	}

	/**
	 * Return array map of objects values
	 * @param $key
	 * @param $value
	 * @return array
	 */
	public function getHashMap($key, $value) {
		$data = [];

		foreach ($this->_objects as $object) {
			$name = $object->getValue($key);
			$data[$name] = $object->getValue($value);
		}

		return $data;
	}

	/**
	 * Returns object values by concrete field
	 * @param $field
	 * @return array
	 */
	public function getValues($field)
	{
		$data = [];
		foreach ($this->_objects as $object) {
			$data[] = $object->getValue($field);
		}

		return $data;
	}

	/**
	 * Returns count of objects in collection
	 * @return int
	 */
	public function getCount()
	{
		return count($this->_objects);
	}

	/**
	 * Returns first object of collection
	 * @return \Core\Object|bool
	 */
	public function getFirst()
	{
		if (!$this->isEmpty()) {
			return $this->_objects[0];
		}

		return false;
	}

	/**
	 * Returns true if collection is empty
	 * @return bool
	 */
	public function isEmpty()
	{
		return empty($this->_objects);
	}

	/**
	 * Returns collection steam
	 * @return Stream
	 */
	public function stream()
	{
		return new Stream($this->_objects);
	}
}
