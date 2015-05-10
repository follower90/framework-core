<?php

namespace Core;

use Core\Database\MySQL;
use Core\Database\PDO;

abstract class Orm
{
	use Query;
	use Objects;

	protected static $_db;
	protected static $_object;

	private static function _connect()
	{
		self::$_db = PDO::getInstance();
	}

	public static function find($class, $filters = [], $values = [], $params = [])
	{
		self::_connect();

		$className = self::detectClass($class);
		static::$_object = new $className();
		static::$_object->fields();

		$query = self::_makeQuery($class, $filters, $values, $params);
		$rows = self::$_db->rows($query);

		if (!isset($fields['languageTable'])) {
			return self::fillCollection($class, $rows);
		}

		foreach ($rows as $key => $row) {
			$query = self::_makeLanguageQuery($class, $row['id']);
			$langRows = self::$_db->rows($query);

			foreach ($langRows as $langRow) {
				$rows[$key]['languageTable'][$langRow['field']] = $langRow['value'];
			}
		}

		return self::fillCollection($class, $rows);
	}

	public static function findOne($class, $filters = [], $values = [])
	{
		$collection = self::find($class, $filters, $values, ['limit' => 1]);
		return $collection->getFirst();
	}

	public static function load($class, $id)
	{
		return self::findOne($class, ['id'], [$id]);
	}

	public static function delete(Object $object)
	{
		if (!$id = $object->getId()) {
			throw new \Exception('Cannot delete object');
		}

		MySQL::delete($object->table(), ['id' => $id]);
		return true;
	}
}
