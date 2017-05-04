<?php
namespace Core;

class ObjectConfig
{
	protected $_config = [
		'table' => '',
		'fields' => [],
		'filters' => [],
		'relations' => [],
	];

	/**
	 * Set object fields
	 * @param $fields
	 */
	public function setFields($fields)
	{
		$this->_config['fields'] = array_merge_recursive($this->_config['fields'], $fields);
	}

	/**
	 * Pre-filter condition
	 * @param $fields
	 */
	public function beforeFilter($filter)
	{
		$this->_config['filters'] = array_merge_recursive($this->_config['filters'], $filter);
	}

	/**
	 * Set object table
	 * @param $table
	 */
	public function setTable($table)
	{
		$this->_config['table'] = $table;
	}

	/**
	 * Set object relation
	 * @param $alias
	 * @param $relation
	 */
	public function setRelation($alias, $relation)
	{
		$this->_config['relations'][$alias] = $relation;
	}

	/**
	 * Get object config data map
	 * @param $alias
	 * @return array
	 */
	public function getData($alias)
	{
		if ($alias && isset($this->_config[$alias])) {
			return $this->_config[$alias];
		}

		return $this->_config;
	}
}