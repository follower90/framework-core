<?php

namespace Core;

class Repository
{
	protected $instance;

	public function __construct($objectName)
	{

	}

	public static function create($objectName)
	{
		return new Repository($objectName);
	}

	public function filter($filters = [], $values = [])
	{

	}

	public function load()
	{

	}
}
