<?php

namespace Core\Database;

class MySQL
{
	/**
	 * Runs Mysql update query
	 * @param $table
	 * @param array $params
	 * @param array $conditions
	 * @throws \Exception
	 */
	public static function update($table, $params = [], $conditions = [])
	{
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
		PDO::getInstance()->query($query);
	}

	/**
	 * Runs Mysql insert query
	 * @param $table
	 * @param array $params
	 * @return mixed
	 * @throws \Exception
	 */
	public static function insert($table, $params = [])
	{
		if (!$table || empty($params)) {
			throw new \Exception('Incorrect insert query');
		}

		$set = [];

		foreach ($params as $field => $value) {
			$set[] = $field . '=' . '\'' . $value . '\'';
		}

		$query = 'INSERT INTO `' . $table . '` SET ' . implode(', ', $set);
		PDO::getInstance()->insert_id($query);
	}

	/**
	 * Deletes from table with specified conditions
	 * @param $table
	 * @param array $conditions
	 * @throws \Exception
	 */
	public static function delete($table, $conditions = [])
	{
		if (!$table || empty($conditions)) {
			throw new \Exception('Incorrect delete query');
		}

		$where = [];

		foreach ($conditions as $field => $value) {
			$where[] = $field . '=' . '\'' . $value . '\'';
		}

		$query = 'DELETE FROM `' . $table . '` WHERE ' . implode(',', $where);
		PDO::getInstance()->query($query);
	}

	/**
	 * Runs RAW Mysql query without any conversions
	 * @param $query
	 */
	public static function query($query)
	{
		PDO::getInstance()->query($query);
	}
}
