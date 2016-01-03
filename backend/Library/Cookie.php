<?php

namespace Core;

class Cookie
{
	/**
	 * Returns cookie by its name
	 * @param $key
	 * @return bool
	 */
	public static function get($key)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
	}

	/**
	 * Set-cookie helper
	 * By default sets cookie on root domain for 1 year period
	 * @param $name
	 * @param $value
	 * @param int $expire
	 * @param string $path
	 * @param null $domain
	 */
	public static function set($name, $value, $expire = 31536000, $path = "/", $domain = null)
	{
		setcookie($name, $value, time() + (int)$expire, $path, $domain);
	}

	/**
	 * Removes cookie by setting expired till time
	 * @param $name
	 */
	public static function remove($name)
	{
		setcookie($name, '', time() - 60 * 60 * 24 * 365, '/');
	}
}
