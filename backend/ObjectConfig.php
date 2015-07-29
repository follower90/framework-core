<?php
namespace Core;

class ObjectConfig
{
	protected $_config = [
		'table' => '',
		'fields' => [],
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