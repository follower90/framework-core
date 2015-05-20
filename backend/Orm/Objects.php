<?php

namespace Core;

trait Objects
{
	protected static $_table;
	protected static $_fields;

	public static function detectClass($class)
	{
		$projects = Config::get('projects');

		foreach ($projects as $project) {

			$className = '\\' . $project . '\\Object\\' . ucfirst($class);
			if (class_exists($className)) {
				return $className;
			}
		}

		$className = '\\Core\\Object\\' . ucfirst($class);
		if (class_exists($className)) {
			return $className;
		}

		throw new \Exception('Object not found');
	}

	public static function checkRelation($object, $alias)
	{
		//todo check if relation and field of related object is exists, and return true/false. try to support nested relations
		//not used now
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

	protected static function fillCollection($class, $data, $params)
	{
		$objects = [];

		array_walk($data, function ($row) use (&$objects, $class) {
			$class = self::_getObject($class);
			$object = new $class();
			$objects[] = self::fillObject($object, $row);

		});

		$collection = new Collection($objects);
		self::$_cache->insert($params, $collection);
		return $collection;
	}
}
