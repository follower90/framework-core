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
		$this->_fields = $object->config();
	}

	public function create($rebuild = false)
	{
		$db = PDO::getInstance();

		if ($rebuild) {
			$db->query('DROP TABLE `' . $this->_table . '`');
			$db->query('DROP TABLE `' . $this->_table . '_Lang`');
		}

		if (isset($this->_fields['languageTable'])) {
			$db->query('CREATE TABLE IF NOT EXISTS `' . $this->_table . '_Lang` (
				`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`' . strtolower($this->_table) . '_id` int NOT NULL,
				`lang` char(2) NOT NULL,
				`field` varchar(20) NOT NULL,
				`value` MEDIUMTEXT
			)');
		}

		$db->query('CREATE TABLE IF NOT EXISTS `' . $this->_table . '` (' . $this->_convertFields() . ')');
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

	public static function createObjects()
	{
		$rootPath = 'vendor';

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
}
