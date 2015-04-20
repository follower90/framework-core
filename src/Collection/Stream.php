<?php

namespace Core\Collection;

class Stream
{
	private $_objects = [];
	private $_stream;

	public function __construct($objects)
	{
		$this->_objects = $objects;
		$this->_stream = $this->_objects;
	}

	public function filter($callback)
	{
		$this->_purgeSteam();

		foreach($this->_objects as $value) {
			if ($callback($value)) {
				$this->_stream[] = $value;
			}
		}

		return $this;
	}

	private function _purgeSteam()
	{
		if (!empty($this->_stream)) {
			$this->_objects = $this->_stream;
			$this->_stream = [];
		}
	}

	public function findFirst()
	{
		return $this->_stream[0] ? $this->_stream[0] : false;
	}

	public function find()
	{
		return $this->_stream;
	}
}
