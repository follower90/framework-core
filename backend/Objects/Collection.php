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

	public function push($object)
	{
		$this->_objects[] = $object;
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
	public function getHashMap($key, $value)
	{
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
	 * Empty the collection
	 * @return \Core\Object|bool
	 */
	public function removeAll()
	{
		foreach ($this->_objects as $object) {
			Orm::delete($object);
		}

		$this->_objects = [];
		return true;
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
	 * Filter collection by key=>value
	 * and return new collection
	 * @param $field
	 * @param $value
	 * @return Collection
	 */
	public function filterBy($field, $value)
	{
		$objects = $this->stream()->filter(function ($o) use ($field, $value) {
			return $o->getValue($field) == $value;
		})->find();

		return new Collection($objects);
	}

	/**
	 * Find single object in collection
	 * @param $field
	 * @param $value
	 * @return bool
	 */
	public function findFirstBy($field, $value)
	{
		return $this->stream()->filter(function ($o) use ($field, $value) {
			return $o->getValue($field) == $value;
		})->findFirst();
	}

	/**
	 * Get related Collection or Object for this Collection
	 * @param $alias
	 * @return Collection
	 */
	public function getRelated($alias)
	{
		$relatedCollection = [];

		foreach ($this->_objects as $o) {
			$related = $o->getRelated($alias);

			if (is_a($related, get_class($this))) {
				foreach ($related->getCollection() as $relatedObject) {
					$relatedCollection[$relatedObject->getId()] = $relatedObject;
				}
			} else {
				$relatedCollection[$related->getId()] = $related;
			}
		}

		return new Collection($relatedCollection);
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
