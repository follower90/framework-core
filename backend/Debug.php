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

	public static function getInstance()
	{
		if (!self::$_instance) {
			self::$_instance = new Debug();
		}

		return self::$_instance;
	}

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

	public function logFile($path)
	{
		$this->_files[] = $path;
	}

	public function logPhpError($error)
	{
		$this->_php_errors[] = $error;
	}

	public function logCmsError($error)
	{
		$this->_cms_errors[] = $error;
	}

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

	public function getQueriesLog()
	{
		return [
			'count' => count($this->_queries),
			'data' => $this->_queries,
		];
	}

	public function getFilesLog()
	{
		return [
			'count' => count($this->_files),
			'data' => $this->_files,
		];
	}

	public function getPhpErrors()
	{
		return [
			'count' => count($this->_php_errors),
			'data' => $this->_php_errors,
		];
	}

	public function getCmsErrors()
	{
		return [
			'count' => count($this->_cms_errors),
			'data' => $this->_cms_errors,
		];
	}

	public function getCmsDumps()
	{
		return [
			'count' => count($this->_cms_dumps),
			'data' => $this->_cms_dumps,
		];
	}
}
