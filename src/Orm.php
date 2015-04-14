<?php

namespace Core;

use Core\Database\PDO;

abstract class Orm extends OrmRelation
{
	private static $_db;

	private static function _connect()
	{
		self::$_db = PDO::getInstance();
	}

	public static function find($class, $filters = [], $values = [], $params = [])
	{
		self::_connect();
		$data = self::_prepareQuery($class, $filters, $values, $params);
		$rows = self::$_db->rows($data['query'], $data['params']);

		foreach ($rows as $key => $row) {
			$query = self::_prepareLanguageQuery($class, $row['id']);
			$langRows = self::$_db->rows($query);

			foreach ($langRows as $langRow) {
				$rows[$key]['languageTable'][$langRow['field']] = $langRow['value'];
			}
		}

		if (!$rows) {
			return new Collection([]);
		}

		return self::fillCollection($class, $rows);
	}

	public static function findOne($class, $filters = [], $values = [])
	{
		$result = self::find($class, $filters, $values, ['limit' => 1]);
		$objects = $result->getCollection();

		return isset($objects[0]) ? $objects[0] : false;
	}

	public static function load($class, $id)
	{
		return self::findOne($class, ['id'], [$id]);
	}

	public static function delete($object)
	{
		$table = $object->table();
		$id = $object->getId();

		if (!$table || !$id) {
			return false;
		}

		self::$_db->query(self::_removeQuery($table, $id));
		return true;
	}
}
