<?php

namespace Core;

class Session
{
	/**
	 * Session start wrapper
	 */
	public static function init()
	{
		session_start();
	}

	/**
	 * Session id wrapper
	 */
	public static function id()
	{
		return session_id();
	}

	/**
	 * Returns session param by key
	 * @param $key
	 * @return bool
	 */
	public static function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
	}

	/**
	 * Sets session param
	 * @param $key
	 * @param $value
	 */
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * Removes session param
	 * @param $key
	 */
	public static function remove($key)
	{
		unset($_SESSION[$key]);
	}
}
