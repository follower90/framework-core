<?php

namespace Core\Database;

/**
 * Interface Database
 * @package Core\Database
 */
interface Database
{
	/**
	 * @param $table
	 * @param array $data
	 * @return mixed
	 */
	public static function insert($table, array $data);

	/**
	 * @param $table
	 * @param array $filters
	 * @return mixed
	 */
	public static function delete($table, array $filters);

	/**
	 * @param $table
	 * @param array $data
	 * @param array $filters
	 * @return mixed
	 */
	public static function update($table, array $data, array $filters);

}