<?php

namespace Core;

use Core\Database\PDO;
use Core\Exception\UserInterface\ObjectValidationException;
use Core\Exception\System\OrmException;

class Orm
{
	use Traits\Orm\OrmCore;

	protected static $_object;
	protected static $_cache;
	protected static $_dbClass = '\\Core\\Database\\MySQL';

	/**
	 * Creates and returns new Object
	 * @param $class
	 * @return \Core\Object
	 */
	public static function create($class)
	{
		return self::_getObject($class);
	}

	public static function setDbType($type)
	{
		if (class_exists($type)) {
			self::$_dbClass = $type;
		}

		throw new \Core\Exception\Exception('Database class does not exist');
	}

	/**
	 * Saves object to database
	 * @param \Core\Object $object
	 * @return bool
	 * @throws \Exception
	 */
	public static function save(&$object)
	{
		$object->beforeSave();

		if (!$object->validate()) {
			throw new ObjectValidationException(implode("\n", $object->getErrors()));
		}

		if (!$object->isModified()) {
			return false;
		}

		$table = $object->getConfigData('table');
		$data = $object->getSimpleFieldsData();

		$dbEngine = self::$_dbClass;

		try {
			if ($object->isNew()) {
				$id = $dbEngine::insert($table, $data);
				$object->setValue('id', $id);
			} else {
				$dbEngine::update($table, $data, ['id' => $object->getId()]);
			}

			self::_updateLangTables($object);
			self::_saveRelatedFieldsData($object);

		} catch (\Exception $e) {
			throw new OrmException('Error inserting data to ' . $table);
		}

		self::getOrmCache()->clear();

		$object->afterSave();
		return true;
	}

	/**
	 * Load objects collection from database
	 * @param $class
	 * @param array $filters
	 * @param array $values
	 * @param array $params
	 * @return bool|\Core\Collection
	 */
	public static function find($class, $filters = [], $values = [], $params = [])
	{
		$cacheParams = [$class, $filters, $values, $params];
		static::$_object = self::_getObject($class);

		if ($result = self::getOrmCache()->get($cacheParams)) {
			return $result;
		}

		$query = self::_makeSimpleQuery($class, $filters, $values, $params);
		$rows = PDO::getInstance()->rows($query);

		$fields = static::$_object->getConfig()->getData('fields');

		if (!isset($fields['languageTable'])) {
			return self::fillCollection($class, $rows, $cacheParams);
		}

		foreach ($rows as $key => $row) {
			$query = self::_makeLanguageQuery($class, $row['id']);
			$langRows = PDO::getInstance()->rows($query);

			foreach ($langRows as $langRow) {
				$rows[$key]['languageTable'][$langRow['field']] = $langRow['value'];
			}
		}

		return self::fillCollection($class, $rows, $cacheParams);
	}


	public static function findBySql($class, $query, $params = [])
	{
		$rows = PDO::getInstance()->rows($query, $params);
		return self::fillCollection($class, $rows);
	}

	/**
	 * Returns count of requested object
	 * @param $class
	 * @param array $filters
	 * @param array $values
	 * @return int
	 */
	public static function count($class, $filters = [], $values = [])
	{
		$cacheParams = [$class, $filters, $values];
		static::$_object = self::_getObject($class);

		if ($result = self::getOrmCache()->get($cacheParams)) {
			return $result;
		}

		$query = self::_makeCountQuery($class, $filters, $values);
		$result = PDO::getInstance()->cell($query);

		return $result;
	}

	/**
	 * Find first object by given parameters
	 * @param $class
	 * @param array $filters
	 * @param array $values
	 * @return \Core\Object
	 */
	public static function findOne($class, $filters = [], $values = [])
	{
		$collection = self::find($class, $filters, $values, ['limit' => 1]);
		return $collection->getFirst();
	}

	/**
	 * Load object by its id
	 * @param $class
	 * @param $id
	 * @return \Core\Object or false
	 */
	public static function load($class, $id)
	{
		return self::findOne($class, ['id'], [$id]);
	}

	/**
	 * Deletes object from database
	 * @param \Core\Object $object
	 * @return bool
	 * @throws \Exception
	 */
	public static function delete($object)
	{
		$object->beforeDelete();
		$dbEngine = self::$_dbClass;

		if ($id = $object->getId()) {
			$dbEngine::delete($object->getConfigData('table'), ['id' => $id]);
		}

		$object->afterDelete();

		unset($object);
		return true;
	}

	/**
	 * Cleans orm cache
	 */
	public static function clearCache()
	{
		self::getOrmCache()->clear();
	}

	/**
	 * returns or creates single Cache object
	 * @return OrmCache
	 */
	private static function getOrmCache()
	{
		if (!self::$_cache) {
			self::$_cache = new OrmCache();
		}

		return self::$_cache;
	}

	/**
	 * @param [type, alias, ...] $relationProperties
	 * @param $targetObjectProperties
	 * @param $relatedObjectProperties
	 * @throws \Exception if target object is illegal
	 */
	public static function registerRelation($relationProperties, $targetObjectProperties, $relatedObjectProperties)
	{
		$targetObject = self::detectClass($targetObjectProperties['class']);

		if (!$targetObject) {
			throw new OrmException('Relation registering error. Could not detect target object');
		}

		$relation = [
			'class' => $targetObjectProperties['class'],
			'field' => isset($targetObjectProperties['field']) ? $targetObjectProperties['field'] : 'id',

			'targetClass' => $relatedObjectProperties['class'],
			'targetField' =>  isset($relatedObjectProperties['field']) ? $relatedObjectProperties['field'] : 'id',

			'type' => isset($relationProperties['type']) ? $relationProperties['type'] : 'simple',
			'table' => isset($relationProperties['table']) ? $relationProperties['table'] : null,
		];

		$targetObject::addRelation($relationProperties['alias'], $relation);
	}

	/**
	 * Returns full class name with namespaces from registered projects by given object name
	 * @param $class
	 * @return string
	 * @throws \Exception
	 */
	public static function detectClass($class)
	{
		$projects = Config::get('projects');
		foreach ($projects as $config) {

			$className = '\\' . $config['project'] . '\\Object\\' . ucfirst($class);
			if (class_exists($className)) {
				return $className;
			}
		}

		$className = '\\Core\\Object\\' . ucfirst($class);
		if (class_exists($className)) {
			return $className;
		}

		throw new OrmException('Object ' . $class . ' was not found');
	}

	/**
	 * Returns new object by requested class name
	 * @param $class string object name
	 * @return \Core\Object
	 * @throws \Exception in detectClass method
	 */
	protected static function _getObject($class)
	{
		$className = self::detectClass($class);
		$object = new $className();
		$object->getConfig();

		return $object;
	}

	/**
	 * Returns collection of objects with specified data
	 * @param $class
	 * @param $data
	 * @param $params
	 * @return \Core\Collection
	 */
	protected static function fillCollection($class, $data, $params = [])
	{
		if (empty($data)) {
			return new Collection([]);
		}

		$objects = [];

		array_walk($data, function ($row) use (&$objects, $class) {
			$class = self::_getObject($class);
			$object = new $class();
			$objects[] = $object->setValues($row);
		});

		$collection = new Collection($objects);
		self::getOrmCache()->update($params, $collection);

		return $collection;
	}
}
