<?php

namespace Core;

class Config {

	private static $config;

	/**
	 * Return connection credentials by alias
	 * @param string $connection
	 * @return mixed
	 */
	public static function dbConnection($connection = 'default')
	{
		return self::$config['connections'][$connection];
	}

	/**
	 * Get config param by key, or get whole config array
	 * @param $item
	 * @return mixed
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
	public static function setDb($alias, $connection)
	{
		self::$config['connections'][$alias] = $connection;
	}

	/**
	 * Set available application languages
	 * @param $alias
	 * @param $config
	 */
	public static function setAvailableLanguages($config)
	{
		self::$config['available_languages'] = $config;
	}

	public static function getAvailableLanguages()
	{
		return self::$config['available_languages'];
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
