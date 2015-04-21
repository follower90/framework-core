<?php

namespace Core;

abstract class OrmRelation {

	protected static $_table = '';
	protected static $_fields = [];
	protected static $_joins = [];

	protected static function _getObject($class)
	{
		$className = self::detectClass($class);
		$object = new $className();

		self::$_table = $object->table();
		self::$_fields = $object->fields();

		return $object;
	}

	public static function detectClass($class)
	{
		$className = '\\Core\\Object\\' . ucfirst($class);
		if (!class_exists($className)) {
			$className = '\\' . Config::get('project') . '\\Object\\' . ucfirst($class);
		}

		return $className;
	}

	protected static function _removeQuery($table, $id)
	{
		return 'delete from ' . $table .' where id=' . $id;
	}

	protected static function _prepareLanguageQuery($class, $id)
	{
		$language = Config::get('site.language');
		$query = 'select field, value from ' . $class . '_Lang where lang=\''. $language. '\' and ' . strtolower($class) . '_id=' .$id;
		return $query;
	}

	protected static function _prepareQuery($class, $filters, $values, $params)
	{
		self::_getObject($class);
		self::$_joins = [];

		$joins = '';
		foreach (self::$_joins as $join) {
			$joins .= ' inner join ' . $join['table'] . ' ' . $join['alias'];
			$joins .= ' on ' . $join['alias'] . '.' . $join['key'] . ' = tb.' . $join['externalKey'] .' ';
		}

		$query = 'select * from ' . self::$_table . ' tb ' . $joins . ' ';
		$query .= self::_where($filters, $values) . ' ';
		$query .= self::_sort($params) . ' ';
		$query .= self::_limit($params);

		return ['query' => $query, 'params' => self::_values($values)];
	}

	protected static function fillObject($object, $data)
	{
		$object->setValues($data);
		return $object;
	}

	protected static function fillCollection($class, $data)
	{
		$objects = [];

		array_walk($data, function ($row) use (&$objects, $class) {
			$class = self::_getObject($class);
			$object = new $class();
			$objects[] = self::fillObject($object, $row);

		});

		return new Collection($objects);
	}

	private static function _sort($params)
	{
		$order = '';
		if (!empty($params['sort'])) {
			$sort = $params['sort'];
			if (isset($sort[1])) {
				$order = 'order by tb.' . $sort[0] . ' ' . $sort[1];
			} else {
				$order = 'order by ' . $sort[0];
			}
		}

		return $order;
	}

	private static function _limit($params)
	{
		$limit = '';
		if (isset($params['limit'])) {
			if (isset($params['offset'])) {
				$limit = 'limit ' . $params['offset'] . ',' . $params['limit'];
			} else {
				$limit = 'limit ' . $params['limit'];
			}
		}

		return $limit;
	}

	private static function _where($params, $values)
	{
		$where = [];
		$alias = 'tb';
		$count = 0;

		foreach ($params as $param) {
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

				self::$_joins[] = [
					'table' => $relatedObject->table(),
					'alias' => $alias,
					'externalKey' => $field[0],
					'key' => $relation['field'],
				];
			}

			$condition = $values[$count];
			$where[] = self::_addParam($alias, $param, $condition);
			$count++;
		}

		if(!empty($where)) {
			return 'where ' . implode(' and ', $where);
		}

		return '';
	}

	private static function _addParam($table, $param, $condition)
	{
		if ($condition === 'null') {
			$where = $table . '.' . $param . ' is null';
		} else if ($condition === '!null') {
			$where = $table . '.' . $param . ' is not null';
		} else {
			if ($param[0] == '!') {
				$where = $table . '.' . substr($param, 1) . '!=?';
			} else {
				if (count($condition) > 1) {
					$placeholder = substr(str_repeat('?,', count($condition)),0, -1);
					$where = $table . '.' . $param . ' in (' . $placeholder . ')';
				} else {
					$where = $table . '.' . $param . '=?';
				}
			}
		}

		return $where;
	}

	private static function _values($values)
	{
		if (!$values) {
			return null;
		}

		$params = [];

		array_walk($values, function($item) use (&$params) {
			if ($item !== 'null' && $item !== '!null') {
				if (is_array($item)) {
					$params = array_merge($params, $item);
				} else {
					$params[] = $item;
				}
			}
		});

		return $params;
	}
}