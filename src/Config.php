<?php

namespace Core;

class Config {

	private static $config;

	public static function dbConnection()
	{
		return self::$config['db_settings'];
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

	public static function setProject($name)
	{
		static::set('project', $name);
	}

	public static function setDb($name, $config)
	{
		static::set('db_settings', $config);
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
