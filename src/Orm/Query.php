<?php

namespace Core;

trait Query
{
	protected static $_table = '';
	protected static $_fields = [];
	protected static $_joins = [];

	public static function detectClass($class)
	{
		$className = '\\Core\\Object\\' . ucfirst($class);
		if (!class_exists($className)) {
			$className = '\\' . Config::get('project') . '\\Object\\' . ucfirst($class);
		}

		return $className;
	}

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

		foreach (self::$_joins as $join) {
			$queryBuilder->join('inner', $join['table'], $join['alias'], [ $join['externalKey'], $join['key'] ]);
		}

		self::buildConditions($queryBuilder, $filters, $values);

		$queryBuilder->offset($params['offset']);
		$queryBuilder->limit($params['limit']);
		$queryBuilder->orderBy($params['sort'][0], $params['sort'][1]);

		return $queryBuilder->composeSelectQuery();
	}

	protected static function buildConditions($queryBuilder, $filters, $values)
	{
		$alias = 'tb';
		$count = 0;

		foreach ($filters as $param) {
			$field = explode('.', $param);

			if (!empty($field[1])) {
				$relation = self::$_fields[$field[0]]['relation'];

				if (empty($relation['field'])) {
					$relation['field'] = 'id';
				}

				$class = self::_detectClass($relation['class']);
				$relatedObject = new $class();

				$alias = 'tb' . (count(self::$_joins) + 1);
				$param = $field[1];

				$queryBuilder->join('inner', $relatedObject->table(), $alias, [ $field[0], $relation['field'] ]);
			}

			$condition = $values[$count];
			$queryBuilder->where($alias. '.' .$param, $condition);
			$count++;
		}
	}
}
