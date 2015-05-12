<?php

namespace Core;

trait Query
{
	protected static function _makeLanguageQuery($class, $id)
	{
		$language = Config::get('site.language');

		$queryBuilder = new \Core\Database\QueryBuilder($class . '_Lang');
		$queryBuilder->select(['field', 'value']);
		$queryBuilder->where('lang', $language);
		$queryBuilder->where(strtolower($class) . '_id', $id);

		return $queryBuilder->composeSelectQuery();
	}

	protected static function _makeQuery($class, $filters, $values, $params)
	{
		$queryBuilder = new \Core\Database\QueryBuilder($class);

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

	protected static function buildConditions($queryBuilder, $filters, $values)
	{
		$alias = 'tb';
		$count = 0;

		foreach ($filters as $param) {
			$field = explode('.', $param);

			if (!empty($field[1])) {
				$relations = static::$_object->relations();

				$relation = $relations[$field[0]];
				$class = self::detectClass($relation['class']);
				$relatedObject = new $class();

				$alias = 'tb' . $count;
				$param = $field[1];

				if (isset($relation['multiple'])) {
					$queryBuilder->join('inner', $relation['table'], $alias, [ static::$_object->table(), 'id' ]);
				} else {
					$queryBuilder->join('inner', $relatedObject->table(), $alias, [ $field[0], $relation['field'] ]);
				}
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

			$queryBuilder->where($alias. '.' .$param, $condition, $action);
			$count++;
		}
	}
}
