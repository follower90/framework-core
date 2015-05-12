<?php

namespace Core;

class Cookie
{
	public static function get($key)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
	}

	public static function set($name, $value, $expire = 31536000, $path = "/", $domain = null)
	{
		setcookie($name, $value, time() + (int)$expire, $path, $domain);
	}

	public static function remove($name)
	{
		setcookie($name, '', time() - 60 * 60 * 24 * 365);
	}
}
