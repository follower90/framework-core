<?php

namespace Core\Database;

class MySQL implements Database
{
	/**
	 * Runs Mysql update query
	 * @param $table
	 * @param array $params
	 * @param array $conditions
	 * @throws \Exception
	 */
	public static function update($table, array $params = [], array $conditions = [])
	{
		if (!$table || empty($params) || empty($conditions)) {
			throw new \Core\Exception\Exception('Incorrect update query');
		}

		$set = [];
		$where = [];

		foreach ($params as $field => $value) {
			$set[] = $field . '=' . '\'' . $value . '\'';
		}

		foreach ($conditions as $field => $value) {
			$where[] = $field . '=' . '\'' . $value . '\'';
		}

		$query = 'UPDATE `' . $table . '` SET ' . implode(', ', $set) . ' WHERE ' . implode(' and ', $where);
		PDO::getInstance()->query($query);
	}

	/**
	 * Runs Mysql insert query
	 * @param $table
	 * @param array $params
	 * @return int $insertId
	 * @throws \Exception
	 */
	public static function insert($table, array $params = [])
	{
		if (!$table || empty($params)) {
			throw new \Core\Exception\Exception('Incorrect insert query');
		}

		$set = [];

		foreach ($params as $field => $value) {
			$set[] = $field . '=' . '\'' . $value . '\'';
		}

		$query = 'INSERT INTO `' . $table . '` SET ' . implode(', ', $set);
		return PDO::getInstance()->insert_id($query);
	}

	/**
	 * Deletes from table with specified conditions
	 * @param $table
	 * @param array $conditions
	 * @throws \Exception
	 */
	public static function delete($table, array $conditions = [])
	{
		if (!$table || empty($conditions)) {
			throw new \Core\Exception\Exception('Incorrect delete query');
		}

		$where = [];

		foreach ($conditions as $field => $value) {
			$where[] = $field . '=' . '\'' . $value . '\'';
		}

		$query = 'DELETE FROM `' . $table . '` WHERE ' . implode(' and ', $where);
		PDO::getInstance()->query($query);
	}

	/**
	 * Runs RAW Mysql query without any conversions
	 * @param $query
	 * @return int success
	 */
	public static function query($query)
	{
		return PDO::getInstance()->query($query);
	}

	/**
	 * Runs RAW Mysql query without any conversions
	 * @param $query
	 * @return Array result of query
	 */
	public static function row($query)
	{
		return PDO::getInstance()->row($query);
	}
}
