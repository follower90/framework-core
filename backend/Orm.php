<?php

namespace Core;

use Core\Database\MySQL;
use Core\Database\PDO;
use Core\Database\QueryBuilder;

class Orm
{
	protected static $_db;
	protected static $_object;
	protected static $_cache;
	protected static $_relations;

	protected static $_table;
	protected static $_fields;

	/**
	 * Creates and return new Object
	 * @param $class
	 * @return \Core\Object
	 */
	public static function create($class)
	{
		return self::_getObject($class);
	}

	/**
	 * Saves object to database
	 * @param \Core\Object $object
	 * @return bool
	 * @throws \Exception
	 */
	public static function save(Object $object)
	{
		if (!$object->isModified()) {
			return false;
		}

		$data = [];
		$langData = [];

		foreach ($object->getValues() as $field => $value) {
			if ($field != 'languageTable') {
				$data[$field] = $value;
			}
		}

		$table = $object->getConfigData('table');
		if ($langTable = $object->getValue('languageTable')) {
			foreach ($langTable as $field => $value) {
				$langData[] = ['field' => $field, 'value'=> $value];
			}
		}

		try {
			if ($id = $object->getId()) {
				MySQL::update($table, $data, ['id' => $id]);
			} else {
				$id = MySQL::insert($table, $data);
			}

		} catch (\Exception $e) {
			throw new \Exception('Error inserting data to ' . $table, 1);
		}

		if ($langData) {
			self::updateLangTables($object, $langData);
		}

		$object->setValue('id', $id);
		return true;
	}

	/**
	 * Save data to language tables, it needed for multi-language web applications
	 * @param $object
	 * @param $data
	 * @throws \Exception
	 */
	protected static function updateLangTables($object, $data)
	{
		$language = Config::get('site.language');
		$table = $object->getConfigData('table');

		foreach ($data as $values) {
			if ($id = $object->getId()) {
				MySQL::update($table . '_Lang', $values, [strtolower($table) . '_id' => $id, 'lang' => $language, 'field' => $values['field']]);
			} else {
				MySQL::insert($table . '_Lang', array_merge([strtolower($table) . '_id' => $id, 'lang' =>$language], $values));
			}
		}
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

		$query = self::_makeQuery($class, $filters, $values, $params);
		$rows = PDO::getInstance()->rows($query);

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

	/**
	 * Find first object by given parameters
	 * @param $class
	 * @param array $filters
	 * @param array $values
	 * @return Object
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
	public static function delete(Object $object)
	{
		if (!$id = $object->getId()) {
			throw new \Exception('Cannot delete object');
		}

		MySQL::delete($object->getConfigData('table'), ['id' => $id]);
		return true;
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
			throw new \Exception('Relation registering error. Could not detect target object');
		}

		$relation = [
			'class' => $relatedObjectProperties['class'],
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

		throw new \Exception('Object ' . $class . ' was not found');
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

		self::$_table = $object->getConfigData('table');
		self::$_fields = $object->getConfigData('fields');

		return $object;
	}

	/**
	 * Fills object with values
	 * @param $object \Core\Object
	 * @param $data
	 * @return \Core\Object
	 */
	protected static function fillObject($object, $data)
	{
		$object->setValues($data);
		return $object;
	}

	/**
	 * Returns collection of objects with specified data
	 * @param $class
	 * @param $data
	 * @param $params
	 * @return \Core\Collection
	 */
	protected static function fillCollection($class, $data, $params)
	{
		$objects = [];

		array_walk($data, function ($row) use (&$objects, $class) {
			$class = self::_getObject($class);
			$object = new $class();
			$objects[] = self::fillObject($object, $row);

		});

		$collection = new Collection($objects);
		self::getOrmCache()->update($params, $collection);
		return $collection;
	}

	/**
	 * It prepares query for selection from language tables, if needed
	 * @param $class
	 * @param $id
	 * @return string
	 */
	protected static function _makeLanguageQuery($class, $id)
	{
		$language = Config::get('site.language');

		$queryBuilder = new QueryBuilder($class . '_Lang');
		$queryBuilder->select(['field', 'value']);
		$queryBuilder->where('lang', $language);
		$queryBuilder->where(strtolower($class) . '_id', $id);

		return $queryBuilder->composeSelectQuery();
	}

	/**
	 * Prepares main ORM select query
	 * @param $class
	 * @param $filters
	 * @param $values
	 * @param $params
	 * @return string
	 */
	protected static function _makeQuery($class, $filters, $values, $params)
	{
		$queryBuilder = new QueryBuilder($class);

		self::buildConditions($queryBuilder, $filters, $values);

		if (isset($params['limit'])) {
			$queryBuilder->limit($params['limit']);
		}

		if (isset($params['offset'])) {
			$queryBuilder->offset($params['offset']);
		}

		if (isset($params['sort'])) {
			$queryBuilder->orderBy($params['sort'][0], $params['sort'][1]);
		}

		return $queryBuilder->composeSelectQuery();
	}

	/**
	 * Builds conditions for where and joins (if relation filters are existing)
	 * @param QueryBuilder $queryBuilder
	 * @param $filters
	 * @param $values
	 */
	protected static function buildConditions(QueryBuilder $queryBuilder, $filters, $values)
	{
		$alias = 'tb';
		$count = 0;

		foreach ($filters as $param) {
			$field = explode('.', $param);

			if (!empty($field[1])) {
				$param = self::buildRelationCondition($queryBuilder, $field, $count);
			}

			$condition = $values[$count];
			$action = '=';

			$firstChar = $param[0];
			$lastChar = $param[strlen($param) - 1];

			if ($firstChar == '>' && $lastChar == '<') {
				$param = substr($param, 1, -1);
				$action = 'between';
			} else if ($lastChar == '>') {
				$param = substr($param, 0, -1);
				$action = '>';
			} else if ($lastChar == '<') {
				$param = substr($param, 0, -1);
				$action = '>';
			}

			$queryBuilder->where($alias . '.' . $param, $condition, $action);
			$count++;
		}
	}

	/**
	 * Builds join and where conditions for relational filters
	 * @param QueryBuilder $queryBuilder
	 * @param $field
	 * @param $count
	 * @return mixed
	 */
	protected static function buildRelationCondition(QueryBuilder $queryBuilder, $field, $count)
	{
		$relations = static::$_object->relations();
		$relation = $relations[$field[0]];

		$relatedObject = self::_getObject($relation['class']);

		$alias = 'tb' . $count;

		if ($relation['type'] == 'multiple') {
			$queryBuilder->join('inner', $relation['table'], $alias, [static::$_object->getConfigData('table'), $relation['field']]);
		} else {
			$queryBuilder->join('inner', $relatedObject->getConfigData('table'), $alias, [$field[0], $relation['field']]);
		}

		return $field[1];
	}
}
