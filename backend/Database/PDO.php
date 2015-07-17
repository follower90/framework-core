<?php

namespace Core\Database;

use Core\Config;
use Core\Debug;

class PDO Extends \PDO
{
	private static $_instance;
	private static $_debugger;

	private $_pattern;
	private $_vars;
	private $_result;
	private $_start;
	private $_sth;

	/**
	 * Constructs new Mysql connection with PDO
	 * @param $settings
	 */
	public function __construct($settings)
	{
		self::$_debugger = Debug::getInstance();

		$db_setts = $settings;

		$db_setts['host'] = 'mysql:host=' . $db_setts['host'] . ';dbname=' . $db_setts['name'];
		$db_setts = [
			$db_setts['host'],
			$db_setts['user'],
			$db_setts['password'],
			[\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . $db_setts['charset'] . "'"]
		];

		if (($num_args = func_num_args()) > 0) {
			$args = func_get_args();
			for ($i = 1; $i < $num_args; $i++) {
				if ($db_setts[$i] !== NULL) {
					$db_setts[$i] = $args[$i];
				}
			}
		}

		try {
			$dbh = call_user_func_array(['PDO', '__construct'], $db_setts);
			$this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $dbh;
		} catch (\Exception $e) {
			throw new \Core\Exception\Exception('Cannot connect to database!');
		}
	}

	/**
	 * Return single instance of PDO connection
	 * @return PDO
	 */
	public static function getInstance()
	{
		if (!self::$_instance) {
			$settings = Config::dbConnection();
			try {
				self::$_instance = new PDO($settings);
			} catch (\Exception $e) {
				echo $e->getMessage();
			}
		}

		return self::$_instance;
	}

	/**
	 * Executes query
	 * @param string $pattern
	 * @param null $vars
	 * @return bool
	 */
	public function query($pattern, $vars = null)
	{
		if (!$this->_executeQuery($pattern, $vars)) {
			return false;
		}

		$this->_result = $this->_sth->rowCount();
		$this->_logQuery();

		return $this->_result;
	}

	/**
	 * Insert query, returns inserted id
	 * @param $pattern
	 * @param null $vars
	 * @return bool|string
	 */
	public function insert_id($pattern, $vars = null)
	{
		if (!$this->_executeQuery($pattern, $vars)) {
			return false;
		}

		$this->_result = $this->lastInsertId();
		$this->_logQuery();

		return $this->_result;
	}

	/**
	 * Selects multiple rows and return associative array
	 * @param $pattern
	 * @param null $vars
	 * @return bool
	 */
	public function rows($pattern, $vars = null)
	{
		if (!$this->_executeQuery($pattern, $vars)) {
			return false;
		}

		$this->_result = $this->_sth->fetchAll(\PDO::FETCH_ASSOC);
		$this->_logQuery();

		return $this->_result;
	}

	/**
	 * Select single row and return associative array
	 * @param $pattern
	 * @param null $vars
	 * @return bool
	 */
	public function row($pattern, $vars = null)
	{
		if (!$this->_executeQuery($pattern, $vars)) {
			return false;
		}

		$this->_result = $this->_sth->fetch(\PDO::FETCH_ASSOC);
		$this->_logQuery();

		return $this->_result;
	}

	/**
	 * Selects single value
	 * @param $pattern
	 * @param null $vars
	 * @return bool
	 */
	public function cell($pattern, $vars = null)
	{
		if (!$this->_executeQuery($pattern, $vars)) {
			return false;
		}

		$this->_result = $this->_sth->fetch(\PDO::FETCH_COLUMN, \PDO::FETCH_ORI_FIRST);
		$this->_logQuery();

		return $this->_result;
	}

	/**
	 * Selects and return key->value array by first two selected cells
	 * @param $pattern
	 * @param null $vars
	 * @return bool
	 */
	public function rows_key($pattern, $vars = null)
	{
		if (!$this->_executeQuery($pattern, $vars)) {
			return false;
		}

		$this->_result = $this->_sth->fetchAll(\PDO::FETCH_KEY_PAIR);
		$this->_logQuery();

		return $this->_result;
	}

	/**
	 * Executes every Mysql query
	 * @param $pattern
	 * @param $vars
	 * @return bool
	 */
	private function _executeQuery($pattern, $vars)
	{
		try {
			$this->_prepareQuery($pattern, $vars);
		} catch (\PDOException $e) {
			return $this->_logError();
		}

		return true;
	}

	/**
	 * Writes query start microtime and executes query
	 * @param $pattern
	 * @param $vars
	 */
	private function _prepareQuery($pattern, $vars)
	{
		$this->_start = microtime(true);
		$this->_pattern = $pattern;
		$this->_vars = $vars;
		$this->_sth = $this->prepare($this->_pattern);
		@$this->_sth->execute($this->_vars);
	}

	/**
	 * Write failed queries to debugger
	 * @return bool
	 */
	private function _logError()
	{
		self::$_debugger->logQuery($this->_pattern, $this->_vars, $this->_result, 0, false);
		return false;
	}

	/**
	 * Writes successful queries to debugger
	 */
	private function _logQuery()
	{
		$results = 0;
		$time = microtime(true) - $this->_start;
		if ($this->_result) {
			$results = count($this->_result);
		}

		self::$_debugger->logQuery($this->_pattern, $this->_vars, $results, round($time, 5), true);
	}
}
