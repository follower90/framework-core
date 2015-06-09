<?php

namespace Core;

abstract class EntryPoint
{
	private $_lib = false;

	/**
	 * Abstract init method
	 * Must be defined in project entry points
	 * @return mixed
	 */
	public abstract function init();

	/**
	 * Default output method
	 * Can be overridden with any data transformation
	 * @param $data
	 * @return mixed
	 */
	public function output($data)
	{
		return $data;
	}

	/**
	 * Return namespace name. Must to have been set at first
	 * @return mixed
	 * @throws \Exception
	 */
	public function getLib()
	{
		if (!$this->_lib) {
			throw new \Core\Exception\Exception('Library namespace is not set');
		}

		return $this->_lib;
	}

	/**
	 * Set method for setting project namespace
	 * @param $path
	 */
	protected function setLib($path)
	{
		$this->_lib = $path;
	}

	/**
	 * Returns POST and GET params merged together
	 * @param bool $key
	 * @return array|bool
	 */
	public function request($key = false)
	{
		$request = array_merge($_POST, $_GET);

		if ($key) {
			return isset($request[$key]) ? $request[$key] : false;
		}

		return $request;
	}

	/**
	 * Switches debug mode
	 * Can be overridden in entry points
	 * @return bool
	 */
	public function debug()
	{
		return true;
	}
}
