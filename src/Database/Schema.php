<?php

namespace Core\Database;

use Core\Object;
use Core\OrmRelation;

class Schema
{
	private $_table;
	private $_fields;

	public function __construct(Object $object)
	{
		$this->_table = $object->table();
		$this->_fields = $object->fields();
	}

	public static function createObjects($path = [], $clearDb)
	{
		if ($clearDb) {
			self::_dropTables();
		}

		foreach($path as $root) {
			self::_createObjects($root);
		}
	}

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

		MySQL::query('CREATE TABLE IF NOT EXISTS `' . $this->_table . '` (' . $this->_convertFields() . ')');
	}

	private static function _createObjects($rootPath)
	{
		$dir = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($rootPath)
		);

		foreach ($dir as $path => $fileInfo) {
			if ($fileInfo->isFile()) {
				$path = explode('/', $fileInfo->getPath());
				$parentDir = $path[sizeof($path) - 1];

				if ($parentDir == 'Object') {
					$className = str_replace('.php', '', $fileInfo->getFilename());
					$className = OrmRelation::detectClass($className);

					$schema = new Schema(new $className());
					$schema->create(true);
				}
			}
		}
	}

	private function _convertFields()
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
