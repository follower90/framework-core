<?php

namespace Core;

class OrmCache
{
	private $_data;

	/**
	 * Insert collection to hash
	 * @param $params
	 * @param $data
	 */
	public function update($params, $data)
	{
		$hash = $this->_hashParams($params);
		$this->_data[$hash] = $data;
	}

	/**
	 * Get collection by hash
	 * @param $params
	 * @return bool
	 */
	public function get($params)
	{
		$hash = $this->_hashParams($params);
		return isset($this->_data[$hash]) ? $this->_data[$hash] : false;
	}

	/**
	 * Clear orm cache
	 */
	public function clear()
	{
		$this->_data = [];
	}

	/**
	 * Hash orm query params
	 * @param $params
	 * @return string
	 */
	private static function _hashParams($params)
	{
		return md5(serialize($params));
	}
}
