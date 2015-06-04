<?php

namespace Core;

class Config {

	private static $config;

	/**
	 * Get default database connection
	 * @todo refactor for use different connections with different projects / objects
	 * @return mixed
	 */
	public static function dbConnection()
	{
		return self::$config['default'];
	}

	/**
	 * Set path to templates folder
	 * @todo refactor for using with multiple projects and templates folders location
	 * @return mixed
	 */
	public static function tplSettings()
	{
		return self::$config['tpl_settings'];
	}

	/**
	 * Get config param by key, or get whole config array
	 * @param $item
	 * @return array
	 */
	public static function get($item)
	{
		if (!$item) {
			return self::$config;
		}

		$query = explode('.', strtolower($item));
		$result = self::$config;

		for ($i = 0; $i < count($query); $i++) {
			$subLevel = $query[$i];
			if (!isset($result[$subLevel])) {
				$result = [];
			} else {
				$result = $result[$subLevel];
			}
		}

		return empty($result) ? [] : $result;
	}

	/**
	 * Register project with its namespace
	 * @param $project
	 * @param $connection
	 */
	public static function registerProject($project, $connection)
	{
		$registered = static::get('projects');
		array_push($registered, ['project' => $project, 'connection' => $connection]);

		static::set('projects', $registered);
	}

	/**
	 * Set database connection params
	 * @param $alias
	 * @param $config
	 */
	public static function setDb($alias, $config)
	{
		static::set($alias, $config);
	}

	/**
	 * Set custom property to Config
	 * @param $item
	 * @param $value
	 */
	public static function set($item, $value)
	{
		$query = explode('.', strtolower($item));
		$result = &self::$config;

		for ($i = 0; $i < count($query); $i++) {
			$subLevel = $query[$i];
			$result = &$result[$subLevel];
		}

		$result = $value;
	}
}
