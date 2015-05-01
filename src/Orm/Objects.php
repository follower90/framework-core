<?php

namespace Core;

trait Objects
{
	protected static $_table;
	protected static $_fields;

	protected static function _getObject($class)
	{
		$className = self::detectClass($class);
		$object = new $className();

		self::$_table = $object->table();
		self::$_fields = $object->fields();

		return $object;
	}

	protected static function fillObject($object, $data)
	{
		$object->setValues($data);
		return $object;
	}

	protected static function fillCollection($class, $data)
	{
		$objects = [];

		array_walk($data, function ($row) use (&$objects, $class) {
			$class = self::_getObject($class);
			$object = new $class();
			$objects[] = self::fillObject($object, $row);

		});

		return new Collection($objects);
	}
}
