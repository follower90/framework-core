<?php

namespace Core;

class Debug
{
	private static $_instance;

	private $_queries;
	private $_files;
	private $_templates;
	private $_resources;
	private $_php_errors;
	private $_framework_errors;
	private $_dumps;
	private $_trace;

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

			$params = array_map(array($this, '_processQueryParam'), $params);
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
	 * Logs used template
	 * @param $path
	 */
	public function logTemplate($path)
	{
		$this->_templates[] = $path;
	}


	/**
	 * Logs used template
	 * @param $path
	 */
	public function logResource($type, $path)
	{
		$this->_resources[$type][] = $path;
	}

	/**
	 * Logs back trace
	 * @param $param
	 */
	public function logTrace($param)
	{
		if ($this->_trace[count($this->_trace) - 1] != $param )
		$this->_trace[] = $param;
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
	public function logFrameworkError($error)
	{
		$this->_framework_errors[] = $error;
	}

	/**
	 * System::vardump logger
	 * @param $dump
	 */
	public function logDump($dump)
	{
		$trace = debug_backtrace();
		$source = $trace[1];

		$this->_dumps[] = [
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
	 * Returns logged templates and its count
	 * @return array
	 */
	public function getTemplatesLog()
	{
		return [
			'count' => count($this->_templates),
			'data' => $this->_templates,
		];
	}

	/**
	 * Returns logged loaded files and its count
	 * @return array
	 */
	public function getResourcesLog()
	{
		$count = 0;
		array_map(function($data) use (&$count) {
			$count += sizeof($data);
		}, $this->_resources);

		return [
			'count' => $count,
			'data' => $this->_resources,
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
	public function getFrameworkErrors()
	{
		return [
			'count' => count($this->_framework_errors),
			'data' => $this->_framework_errors,
		];
	}

	/**
	 * Returns logged variable dumps and its count
	 * @return array
	 */
	public function getDumps()
	{
		return [
			'count' => count($this->_dumps),
			'data' => $this->_dumps,
		];
	}

	/**
	 * Returns logged variable dumps and its count
	 * @return array
	 */
	public function getTrace()
	{
		return [
			'count' => count($this->_trace),
			'data' => $this->_trace,
		];
	}
	
	private function _processQueryParam($param)
	{
		if (!is_numeric($param)) {
			return "'" . $param . "'";
		}

		return $param;
	}
}
