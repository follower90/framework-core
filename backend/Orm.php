<?php

namespace Core;

use Core\Database\MySQL;
use Core\Database\PDO;
use Core\Database\QueryBuilder;
use Core\Exception\UserInterface\ObjectValidationException;
use Core\Exception\System\OrmException;

class Orm
{
	protected static $_object;
	protected static $_cache;

	/**
	 * Creates and returns new Object
	 * @param $class
	 * @return \Core\Object
	 */
	public static function create(string $class)
	{
		return self::_getObject($class);
	}

	/**
	 * Saves object to database
	 * @param \Core\Object $object
	 * @return bool
	 * @throws \Exception
	 */
	public static function save(Object &$object)
	{
		$object->beforeSave();

		if (!$object->validate()) {
			throw new ObjectValidationException($object->getClassName() . ' is not valid object');
		}

		if (!$object->isModified()) {
			return false;
		}

		$table = $object->getConfigData('table');
		$data = $object->getSimpleFieldsData();
		$relatedFields = $object->getHasManyRelationFieldsData();
		$langData = $object->getLanguageFieldsData();

		try {
			if ($object->isNew()) {
				$id = MySQL::insert($table, $data);
				$object->setValue('id', $id);
			} else {
				MySQL::update($table, $data, ['id' => $object->getId()]);
			}

			if ($langData) {
				self::updateLangTables($object, $langData);
			}

			//todo refactor this SHIT

			if ($relatedFields) {
				foreach ($relatedFields as $field => $data) {
					foreach ($object->relations() as $alias => $config) {
						if ($alias == $field) {
							$table =  $config['table'];
							$me = $object->getClassName();
							$related = $config['targetClass'];

							MySQL::delete($table, [$me => $object->getId()]);

							foreach ($data as $val) {
								MySQL::insert($table, [$me => $object->getId(), $related => $val]);
							}
						}
					}
				}
			}
		} catch (\Exception $e) {
			throw new OrmException('Error inserting data to ' . $table);
		}

		self::getOrmCache()->clear();

		$object->afterSave();
		return true;
	}

	/**
	 * Save data to language tables, it needed for multi-language web applications
	 * @param \Core\Object $object
	 * @param array $data
	 * @throws \Exception
	 */
	protected static function updateLangTables($object, $data)
	{
		$language = Config::get('site.language');

		$table = $object->getConfigData('table');
		$langTable = $object->getLangTableName();

		foreach ($data as $values) {

			$queryBuilder = new QueryBuilder($langTable);
			$queryBuilder
				->where(strtolower($table) . '_id', $object->getId())
				->where('lang', $language)
				->where('field', $values['field']);

			$hasData = MySQL::row($queryBuilder->composeSelectCountQuery());
			$hasValue = $hasData['count'];

			if ($hasValue) {
				$queryBuilder->where('value', $values['value']);
				$sameValue = MySQL::row($queryBuilder->composeSelectCountQuery());

				$valueChanged = !$sameValue['count'];

				if ($valueChanged) {
					MySQL::update($langTable, $values, [strtolower($table) . '_id' => $object->getId(), 'lang' => $language, 'field' => $values['field']]);
				}

			} else {
				MySQL::insert($langTable, array_merge([strtolower($table) . '_id' => $object->getId(), 'lang' =>$language], $values));
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
		$object->beforeDelete();

		if ($id = $object->getId()) {
			MySQL::delete($object->getConfigData('table'), ['id' => $id]);
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
			'class' => $relatedObjectProperties['class'],
			'field' => isset($targetObjectProperties['field']) ? $targetObjectProperties['field'] : 'id',

			'targetClass' => $targetObjectProperties['class'],
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
	protected static function fillCollection($class, $data, $params)
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
		$queryBuilder
			->select('field')
			->select('value')
			->where('lang', $language)
			->where(strtolower($class) . '_id', $id);

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
	protected static function _makeSimpleQuery($class, $filters, $values, $params)
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

	protected static function _makeCountQuery($class, $filters, $values, $params = [])
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

		return $queryBuilder->composeSelectCountQuery();
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
				list($param, $alias) = self::buildRelationCondition($queryBuilder, $field, $count);
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
	 * @param $index
	 * @return mixed
	 */
	protected static function buildRelationCondition(QueryBuilder $queryBuilder, $field, $index)
	{
		$relations = self::$_object->relations();
		$relation = $relations[$field[0]];

		$relatedObject = self::_getObject($relation['targetClass']);
		$alias = 'tb' . $index;

		if ($relation['type'] == 'multiple') {
			$queryBuilder->join('inner', $relation['table'], $alias, [self::$_object->getConfigData('table'), $relation['field']]);
		} else {
			$queryBuilder->join('inner', $relatedObject->getConfigData('table'), $alias, [$field[0], $relation['field']]);
		}

		return [$field[1], $alias];
	}
}
