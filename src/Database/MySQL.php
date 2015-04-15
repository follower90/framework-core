<?php

namespace Core\Database;

class MySQL
{
	private static $_db;

	public static function update($table, $params = [], $conditions = [])
	{
		self::_connect();

		if (!$table || empty($params) || empty($conditions)) {
			throw new \Exception('Incorrect update query');
		}

		$set = [];
		$where = [];

		foreach ($params as $field => $value) {
			$set[] = $field . '=' . '\'' . $value . '\'';
		}

		foreach ($conditions as $field => $value) {
			$where[] = $field . '=' . '\'' . $value . '\'';
		}

		$query = 'UPDATE `' . $table . '` SET ' . implode(', ', $set) . ' WHERE ' . implode(', ', $where);
		self::$_db->query($query);
	}

	public static function insert($table, $params = [])
	{
		self::_connect();

		if (!$table || empty($params)) {
			throw new \Exception('Incorrect insert query');
		}

		$set = [];

		foreach ($params as $field => $value) {
			$set[] = $field . '=' . '\'' . $value . '\'';
		}

		$query = 'INSERT INTO `' . $table . '` SET ' . implode(', ', $set);
		return self::$_db->insert_id($query);
	}

	public static function delete($table, $conditions = [])
	{
		self::_connect();

		if (!$table || empty($conditions)) {
			throw new \Exception('Incorrect delete query');
		}

		$where = [];

		foreach ($conditions as $field => $value) {
			$where[] = $field . '=' . '\'' . $value . '\'';
		}

		$query = 'DELETE FROM `' . $table . ' WHERE ' . implode(',', $where);
		self::$_db->query($query);
	}

	public static function query($query)
	{
		self::_connect();
		self::$_db->query($query);
	}

	private static function _connect()
	{
		self::$_db = PDO::getInstance();
	}
}
