<?php

namespace Core;

class OrmMapper
{
	private $_collection = [];
	private $_fields = [];
	private $_filters = [];

	public function getCollection()
	{
		return $this->_collection;
	}
}
