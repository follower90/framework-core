<?php

namespace Core\Collection;

use \Core\Collection;

class Stream
{
	private $_objects = [];
	private $_stream;

	/**
	 * Sets array of objects to new stream
	 * @param array $objects
	 */
	public function __construct($objects)
	{
		$this->_objects = $objects;
		$this->_stream = $this->_objects;
	}

	/**
	 * Applies function filter for stream filtering
	 * @param $callback
	 * @return $this
	 */
	public function filter($callback)
	{
		$this->_purgeSteam();

		foreach ($this->_objects as $value) {
			if ($callback($value)) {
				$this->_stream[] = $value;
			}
		}

		return $this;
	}

	/**
	 * Reassigns filtered stream to collection
	 */
	private function _purgeSteam()
	{
		if (!empty($this->_stream)) {
			$this->_objects = $this->_stream;
			$this->_stream = [];
		}
	}

	/**
	 * Returns first element of stream
	 * @return bool
	 */
	public function findFirst()
	{
		return $this->_stream[0] ? $this->_stream[0] : false;
	}

	/**
	 * Return all stream
	 * @return array|Collection
	 */
	public function find()
	{
		return $this->_stream;
	}

	/**
	 * Returns true if stream is empty
	 * @return bool
	 */
	public function isEmpty()
	{
		return ($this->size() == 0);
	}

	/**
	 * Returns count of objects in the stream
	 * @return int
	 */
	public function size()
	{
		return count($this->_stream);
	}
}
