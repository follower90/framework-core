<?php

namespace Core;

trait Objects
{
	protected static $_table;
	protected static $_fields;

	public static function detectClass($class)
	{
		$className = '\\' . Config::get('project') . '\\Object\\' . ucfirst($class);

		if (!class_exists($className)) {
			$className = '\\Core\\Object\\' . ucfirst($class);
		}

		return $className;
	}

	public static function checkRelation($object, $alias)
	{
		//todo check if relation and field of related object is exists, and return true/false. try to support nested relations
		return false;
	}

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
