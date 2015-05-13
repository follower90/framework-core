<?php

namespace Core;

use Core\Database\MySQL;
use Core\Database\PDO;

class Orm
{
	use Query;
	use Objects;

	protected static $_db;
	protected static $_object;
	protected static $_cache;

	private static function _connect()
	{
		self::$_db = PDO::getInstance();
	}

	public static function find($class, $filters = [], $values = [], $params = [])
	{
		self::_connect();
		self::_initCache();

		$cacheParams = [$class, $filters, $values, $params];

		$className = self::detectClass($class);
		static::$_object = new $className();


		\Core\Library\System::dump($class);
		if ($result = self::$_cache->get($cacheParams)) {
			return $result;
		}

		$query = self::_makeQuery($class, $filters, $values, $params);
		$rows = self::$_db->rows($query);

		if (!isset($fields['languageTable'])) {
			return self::fillCollection($class, $rows, $cacheParams);
		}

		foreach ($rows as $key => $row) {
			$query = self::_makeLanguageQuery($class, $row['id']);
			$langRows = self::$_db->rows($query);

			foreach ($langRows as $langRow) {
				$rows[$key]['languageTable'][$langRow['field']] = $langRow['value'];
			}
		}

		return self::fillCollection($class, $rows, $cacheParams);
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

	private static function _initCache()
	{
		if (!self::$_cache) {
			self::$_cache = new OrmCache();
		}
	}

}
