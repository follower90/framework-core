<?php

namespace Core;

abstract class EntryPoint extends Controller
{
	private $_lib;

	public function init()
	{

	}

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

	public function debug()
	{
		return true;
	}
}
