<?php

namespace Core\Database;

class QueryBuilder { //todo sql query builder

	private $_config;

	/**
	 * Set up base table and it's alias
	 * @param $table
	 */
	public function __construct($table)
	{
		$this->_config['table'] = [$table];
		$this->_config['alias'] = 'tb';
	}

	/**
	 * Setups params for selections
	 * @param $field
	 * @param string $alias
	 * @param string $table
	 * @return $this
	 */
	public function select($field, $alias = '', $table = '')
	{
		if (isset($field)) {
			$this->_config['fields'][] = [
				'field' => $field,
				'alias' => $alias,
				'table' => $table,
			];
		}

		return $this;
	}

	/**
	 * Setups base table alias
	 * @param $alias
	 * @return $this
	 */
	public function setBaseAlias($alias)
	{
		$this->_config['alias'] = $alias;
		return $this;
	}

	/**
	 * Setups joins
	 * @param $type
	 * @param $table
	 * @param $alias
	 * @param $relations
	 * @return $this
	 */
	public function join($type, $table, $alias, $relations)
	{
		if(isset($type,$table, $alias) && sizeof($relations) == 2) {
			$this->_config['joins'][] = [
				'type' => $type,
				'table' => $table,
				'alias' => $alias,
				'field' => $relations[0],
				'external' => $this->applyAlias($relations[1]),
			];
		}

		return $this;
	}

	/**
	 * Setups where conditions
	 * @param $value
	 * @param $args
	 * @param string $action
	 * @return $this
	 */
	public function where($value, $args, $action = '=')
	{
		if (isset($value, $action)) {
			$this->_config['where'][] = [
				'value' => $this->applyAlias($value),
				'args' => is_null($args) ? 'null' : $args,
				'action' => $action,
			];
		}

		return $this;
	}

	/**
	 * Setups order by conditions
	 * @param $field
	 * @param string $direction
	 * @return $this
	 */
	public function orderBy($field, $direction = 'asc')
	{
		if (isset($field)) {
			$this->_config['order'][] = [
				'field' => $this->applyAlias($field),
				'direction' => $direction,
			];
		}

		return $this;
	}

	/**
	 * Setups group by conditions
	 * @param $field
	 * @return $this
	 */
	public function groupBy($field)
	{
		if (isset($field)) {
			$this->_config['group'][] = [
				'field' => $this->applyAlias($field),
			];
		}

		return $this;
	}

	/**
	 * Offset setup
	 * @param $value
	 * @return $this
	 */
	public function offset($value)
	{
		if (isset($value)) {
			$this->_config['offset'] = [$value];
		}

		return $this;
	}

	/**
	 * Limit setup
	 * @param $value
	 * @return $this
	 */
	public function limit($value)
	{
		if (isset($value)) {
			$this->_config['limit'] = [$value];
		}

		return $this;
	}

	/**
	 * Composes raw mysql query based on QueryBuilder setup
	 * @return string
	 */
	public function composeSelectQuery()
	{
		$query = 'select ';
		$query .= implode(', ', $this->_composeFields()) . ' from ' . reset($this->_config['table']) . ' ';
		return $this->_composeQuery($query);
	}

	/**
	 * Composes mysql query based on QueryBuilder setup for getting count of objects only
	 * @return string
	 */
	public function composeSelectCountQuery()
	{
		$query = 'select count(*) as `count` from ' . reset($this->_config['table']) . ' ';
		return $this->_composeQuery($query);
	}

	private function _composeQuery($query)
	{
		if (isset($this->_config['alias'])) {
			$query .= $this->_config['alias'] . ' ';
		}

		$query .= implode(' ', $this->_composeJoins());

		if ($conditions = $this->_composeConditions()) {
			$query .= ' where ' . implode(' and ', $conditions);
		}

		$query .= $this->_composerOrder();
		$query .= $this->_composeGrouping();
		$query .= $this->_composeLimit();

		return $query;
	}

	/**
	 * Fields composer
	 * @return array
	 */
	private function _composeFields()
	{
		$fields = [];

		if (empty($this->_config['fields'])) {
			$this->select('*');
		}

		foreach ($this->_config['fields'] as $raw) {
			$field = '';

			if ($raw['table']) {
				$field .= $raw['table'] . '.';
			} else if (isset($this->_config['alias'])) {
				$field .=  $this->_config['alias'] . '.';
			}

			$field .= $raw['field'];

			if ($raw['alias']) {
				$field .= ' as ' . $raw['alias'];
			}

			$fields[] = $field;
		}

		return $fields;
	}

	/**
	 * Joins composer
	 * @return array
	 */
	private function _composeJoins()
	{
		$joins = [];

		if (!empty($this->_config['joins'])) {
			foreach ($this->_config['joins'] as $raw) {
				$join = $raw['type'] . ' join ' . $raw['table'] . ' ' . $raw['alias'];
				$join .= ' on ' . $raw['alias'] . '.' . $raw['field'] . ' = ' . $raw['external'];

				$joins[] = $join;
			}
		}

		return $joins;
	}

	/**
	 * Conditions composer
	 * @return array
	 */
	private function _composeConditions()
	{
		$conditions = [];
		if (!empty($this->_config['where'])) {
			foreach ($this->_config['where'] as $raw) {
				if (!is_array($raw['args'])) {
					$raw['args'] = [$raw['args']];
				}

				if (!empty($raw['args'])) {
					array_walk($raw['args'], function (&$item) {
						if (!is_numeric($item) && $item != 'null' && $item != '!null') {
							$item = '\'' . $item . '\'';
						}
					});
				}

				if (count($raw['args']) > 1) {
					if ($raw['action'] == 'between') {
						$where = $raw['value'] . ' between '. $raw['args'][0] . ' and ' . $raw['args'][1];
					} else {
						$where = $raw['value'] . ' in (' . implode(',', $raw['args']) . ')';
					}
				} else {
					$value = reset($raw['args']);

					if ($value == 'null') {
						$where = $raw['value'] . ' is null';
					} else {
						$where = $raw['value'] . ' ' .$raw['action'] . ' ' . $value;
					}
				}

				$conditions[] = $where;
			}
		}

		return $conditions;
	}

	/**
	 * Order composer
	 * @return string
	 */
	private function _composerOrder()
	{
		$order = [];
		if (!empty($this->_config['order'])) {
			if (!empty($this->_config['order'])) {
				foreach ($this->_config['order'] as $raw) {
					$order[] = $raw['field'] . ' ' . $raw['direction'];
				}
			}

			if (!empty($order)) {
				return ' order by ' . implode(', ', $order);
			}
		}

		return '';
	}

	/**
	 * Grouping composer
	 * @return string
	 */
	private function _composeGrouping()
	{
		$group = [];

		if (!empty($this->_config['group'])) {
			foreach ($this->_config['group'] as $raw) {
				$group[] = $raw['field'];
			}
		}

		if (!empty($group)) {
			return ' group by ' . implode(', ', $group);
		}

		return '';
	}

	/**
	 * Offset and limit composer
	 * @return string
	 */
	private function _composeLimit()
	{
		if (isset($this->_config['limit'])) {
			$limit = reset($this->_config['limit']);
			if (isset($this->_config['offset'])) {
				$offset = reset($this->_config['offset']);
				return ' limit ' . $offset . ',' . $limit;
			}
			return ' limit ' . $limit;
		}

		return '';
	}

	/**
	 * Returns QueryBuilder config data
	 * @param bool $section
	 * @return mixed
	 */
	public function debug($section = false)
	{
		if (!$section) {
			return $this->_config;
		}

		return $this->_config[$section];
	}

	/**
	 * Applies table/param alias
	 * @param $value
	 * @return mixed|string
	 */
	private function applyAlias($value)
	{
		if (isset($this->_config['alias']) && strpos($value, '.') === false) {

			if (strpos($value, '(') !== false) {
				$value = preg_replace('/^(\w+)\((\w+)\)/i', '${1}(' . $this->_config['alias'] . '.${2})', $value);
			} else {
				$value = $this->_config['alias'] . '.' . $value;
			}
		}

		return $value;
	}
}
