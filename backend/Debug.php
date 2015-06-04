<?php

namespace Core;

class Debug
{
	private static $_instance;

	private $_queries;
	private $_files;
	private $_php_errors;
	private $_cms_errors;
	private $_cms_dumps;

	public static $phpErrorCode = [
		1 => 'Fatal Error',
		2 => 'Warning',
		4 => 'Parse Error',
		8 => 'Notice',
	];

	/**
	 * Returns single instance of debugger
	 * @return Debug
	 */
	public static function getInstance()
	{
		if (!self::$_instance) {
			self::$_instance = new Debug();
		}

		return self::$_instance;
	}

	/**
	 * Logs MySQL query to debugger
	 * @param $query
	 * @param $params
	 * @param $results
	 * @param int $time
	 * @param bool $success
	 */
	public function logQuery($query, $params, $results, $time = 0, $success = true)
	{
		if (!empty($params)) {
			foreach ($params as $key => $param) {
				if (is_array($param)) {
					$params[$key] = implode(',', $param);
				}
			}

			$params = array_map(function ($param) {
				if (!is_numeric($param)) {
					return "'" . $param . "'";
				}

				return $param;
			}, $params);
		}

		$this->_queries[] = [
			'query' => $query,
			'params' => $params,
			'success' => $success,
			'results' => $results,
			'time' => round($time, 4),
		];
	}

	/**
	 * Logs loaded files
	 * @param $path
	 */
	public function logFile($path)
	{
		$this->_files[] = $path;
	}

	/**
	 * Logs php errors
	 * @param $error
	 */
	public function logPhpError($error)
	{
		$this->_php_errors[] = $error;
	}

	/**
	 * Logs framework errors
	 * @param $error
	 */
	public function logCmsError($error)
	{
		$this->_cms_errors[] = $error;
	}

	/**
	 * System::vardump logger
	 * @param $dump
	 */
	public function logDump($dump)
	{
		$trace = debug_backtrace();
		$source = $trace[1];

		$this->_cms_dumps[] = [
			'file' => $source['file'],
			'line' => $source['line'],
			'dump' => $dump,
		];
	}

	/**
	 * Returns logged mysql queries and its count
	 * @return array
	 */
	public function getQueriesLog()
	{
		return [
			'count' => count($this->_queries),
			'data' => $this->_queries,
		];
	}

	/**
	 * Returns logged loaded files and its count
	 * @return array
	 */
	public function getFilesLog()
	{
		return [
			'count' => count($this->_files),
			'data' => $this->_files,
		];
	}

	/**
	 * Returns logged PHP errors and its count
	 * @return array
	 */
	public function getPhpErrors()
	{
		return [
			'count' => count($this->_php_errors),
			'data' => $this->_php_errors,
		];
	}

	/**
	 * Returns logged framework errors and its count
	 * @return array
	 */
	public function getCmsErrors()
	{
		return [
			'count' => count($this->_cms_errors),
			'data' => $this->_cms_errors,
		];
	}

	/**
	 * Returns logged variable dumps and its count
	 * @return array
	 */
	public function getCmsDumps()
	{
		return [
			'count' => count($this->_cms_dumps),
			'data' => $this->_cms_dumps,
		];
	}
}
