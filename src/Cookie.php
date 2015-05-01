<?php

namespace Core;

class Cookie {
	
	public static function get($key)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
	}

	public static function set($name, $value, $expire = false, $path = "/", $domain = null)
	{
		if (!$expire) {
			$expire = 60 * 60 * 24 * 365;
		}

		setcookie($name, $value, time() + (int)$expire, $path, $domain);
	}
}
