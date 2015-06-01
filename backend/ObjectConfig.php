<?php
namespace Core;

class ObjectConfig
{
	protected $_config = [
		'table' => '',
		'fields' => [],
		'relations' => [],
	];

	public function setFields($fields)
	{
		$this->_config['fields'] = array_merge($this->_config['fields'], $fields);
	}

	public function setTable($table)
	{
		$this->_config['table'] = $table;
	}

	public function getData($alias)
	{
		if ($alias && isset($this->_config[$alias])) {
			return $this->_config[$alias];
		}

		return $this->_config;
	}
}