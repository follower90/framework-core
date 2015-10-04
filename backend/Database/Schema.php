<?php

namespace Core\Database;

use Core\Object;
use Core\Orm;

class Schema
{
	private $_object;
	private $_table;
	private $_fields;

	/**
	 * Setups object table and fields
	 * @param \Core\Object $object
	 */
	public function __construct(Object $object)
	{
		$this->_object = $object;
		$this->_table = $object->getConfigData('table');
		$this->_fields = $object->getConfigData('fields');
	}

	/**
	 * Process launch method, setups for wiping database
	 * @param array $path
	 * @param array $params
	 */
	public static function createObjects($path = [], $params = [])
	{
		if ($params['clearDb']) {
			self::_dropTables();
		}

		foreach($path as $root) {
			self::_createObjects($root, $params);
		}
	}

	/**
	 * Creates table by object name
	 * @param array $name
	 * @param array $params
	 */
	public static function createObject($name, $params = [])
	{
		$className = Orm::detectClass($name);

		$schema = new Schema(new $className());

		$dropTable = isset($params['dropTable']) ? true : false;
		$schema->create($dropTable);
	}

	/**
	 * Rebuilds table for object, rebuild param drops existing tables
	 * @param bool $rebuild
	 */
	public function create($rebuild = false)
	{
		if ($rebuild) {
			MySQL::query('DROP TABLE `' . $this->_table . '`');
			MySQL::query('DROP TABLE `' . $this->_table . '_Lang`');
		}

		if (isset($this->_fields['languageTable'])) {
			MySQL::query('CREATE TABLE IF NOT EXISTS `' . $this->_table . '_Lang` (
				`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`' . strtolower($this->_table) . '_id` int NOT NULL,
				`lang` char(2) NOT NULL,
				`field` varchar(20) NOT NULL,
				`value` MEDIUMTEXT
			)');
		}

		MySQL::query('CREATE TABLE IF NOT EXISTS `' . $this->_table . '` (' . $this->_prepareFields() . ')');

		foreach ($this->_object->relations() as $relation) {
			if ($relation['type'] == 'multiple') {
				MySQL::query('CREATE TABLE IF NOT EXISTS `' . $relation['table'] . '` (
					`' . $this->_table . '` int NOT NULL,
					`' . $relation['class'] . '` int NOT NULL
				)');
			}
		}
	}

	/**
	 * Launches table rebuilding for all objects in defined path
	 * @param $rootPath
	 * @param array $params
	 * @throws \Core\Object
	 */
	private static function _createObjects($rootPath, $params = [])
	{
		$dir = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($rootPath . '/Object/')
		);

		foreach ($dir as $path => $fileInfo) {
			if ($fileInfo->isFile()) {
				$path = explode('/', $fileInfo->getPath());
				$parentDir = $path[sizeof($path) - 1];

				$className = str_replace('.php', '', $fileInfo->getFilename());
				if ($parentDir != 'Object') {
					$className = $parentDir . '_' . $className;
				}

				$className = Orm::detectClass($className);

				$schema = new Schema(new $className());

				$dropTable = isset($params['dropTable']) ? true : false;
				$schema->create($dropTable);
			}
		}
	}

	/**
	 * Prepares fields for creating table
	 * @return string
	 */
	private function _prepareFields()
	{
		$result = [];

		foreach ($this->_fields as $field => $params) {

			if ($field == 'languageTable') {
				continue;
			}

			$tmp = '`' . $field . '` ' . $params['type'];

			if (in_array($params['type'], ['char', 'varchar'])) {
				$length = isset($params['length']) ? $params['length'] : 100;
				$tmp .= '(' . $length . ')';
			}

			$tmp .= ($params['null']) ? ' NULL' : ' NOT NULL';
			$tmp .= ($params['default']) ? ' DEFAULT ' . $params['default'] : '';


			if ($field == 'id') {
				$tmp .= ' AUTO_INCREMENT PRIMARY KEY';
			}

			$result[] = $tmp;
		}

		return implode(',', $result);
	}

	/**
	 * Drops all tables in database
	 */
	private static function _dropTables()
	{
		MySQL::query("
			SET FOREIGN_KEY_CHECKS = 0;
			SET GROUP_CONCAT_MAX_LEN=32768;
			SET @views = NULL;
			SELECT GROUP_CONCAT('`', TABLE_NAME, '`') INTO @views
			  FROM information_schema.views
			  WHERE table_schema = (SELECT DATABASE());
			SELECT IFNULL(@views,'dummy') INTO @views;

			SET @views = CONCAT('DROP VIEW IF EXISTS ', @views);
			PREPARE stmt FROM @views;
			EXECUTE stmt;
			DEALLOCATE PREPARE stmt;
			SET FOREIGN_KEY_CHECKS = 1;
		");
	}
}
