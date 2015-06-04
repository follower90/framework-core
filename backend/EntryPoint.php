<?php

namespace Core;

abstract class EntryPoint
{
	private $_lib;

	public abstract function init();

	public function output($data)
	{
		return $data;
	}

	public function getLib()
	{
		return $this->_lib;
	}

	protected function setLib($path)
	{
		$this->_lib = $path;
	}

	public function request($key = false)
	{
		$request = array_merge($_POST, $_GET);

		if ($key) {
			return isset($request[$key]) ? $request[$key] : false;
		}

		return $request;
	}

	public function debug()
	{
		return true;
	}
}
