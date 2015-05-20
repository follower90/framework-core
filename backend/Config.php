<?php

namespace Core;

class Config {

	private static $config;

	public static function dbConnection()
	{
		return self::$config['default'];
	}

	public static function tplSettings()
	{
		return self::$config['tpl_settings'];
	}

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

		return $result;
	}

	public static function registerProject($project, $connection)
	{
		static::set('projects', array_merge(
			static::get('projects'),
			['project' => $project, 'connection' => $connection]
		));
	}

	public static function setDb($alias, $config)
	{
		static::set($alias, $config);
	}

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
