<?php

namespace Core\Traits\Orm;

use Core\Database\MySQL;
use Core\Database\QueryBuilder;
use Core\Config;

trait OrmCore
{

	/**
	 * Saves related fields data
	 * @param Object $object
	 * @throws Exception\Exception
	 */
	private static function _saveRelatedFieldsData($object)
	{
		if (!$relatedFields = $object->getHasManyRelationFieldsData()) {
			return;
		}

		foreach ($relatedFields as $field => $data) {
			foreach ($object->relations() as $alias => $config) {
				if ($alias == $field) {
					$table = $config['table'];
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

	/**
	 * Save data to language tables, it needed for multi-language web applications
	 * @param \Core\Object $object
	 * @throws \Exception
	 */
	private static function _updateLangTables($object)
	{
		if (!$langData = $object->getLanguageFieldsData()) {
			return;
		}

		$language = Config::get('site.language');

		$table = $object->getConfigData('table');
		$langTable = $object->getLangTableName();

		foreach ($langData as $values) {

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
				MySQL::insert($langTable, array_merge([strtolower($table) . '_id' => $object->getId(), 'lang' => $language], $values));
			}
		}
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
		self::_buildConditions($queryBuilder, $filters, $values);

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
		self::_buildConditions($queryBuilder, $filters, $values);

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
	protected static function _buildConditions(QueryBuilder $queryBuilder, $filters, $values)
	{
		$alias = 'tb';
		$count = 0;

		foreach ($filters as $param) {
			$field = explode('.', $param);

			if (!empty($field[1])) {
				list($param, $alias) = self::_buildRelationCondition($queryBuilder, $field, $count);
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
	protected static function _buildRelationCondition(QueryBuilder $queryBuilder, $field, $index)
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
