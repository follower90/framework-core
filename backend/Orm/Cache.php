<?php

namespace Core;

class OrmCache
{
	private $_data;

	public function insert($params, $data)
	{
		$hash = $this->_hashParams($params);
		$this->_data[$hash] = $data;
	}

	public function get($params)
	{
		$hash = $this->_hashParams($params);
		return isset($this->_data[$hash]) ? $this->_data[$hash] : false;
	}

	private static function _hashParams($params)
	{
		return md5(serialize($params));
	}
}
