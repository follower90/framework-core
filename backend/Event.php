<?php

namespace Core;

class Event
{
	private static $_handlers = [];
	private static $_listeners = [];

	/**
	 * Registering event handler
	 * @param EventHandler $handler
	 */
	public static function registerHandler(EventHandler $handler)
	{
		if (!in_array($handler, static::$_handlers)) {
			static::$_handlers[] = $handler;
		}
	}

	/**
	 * Dispatches event
	 * Can send data array and callback
	 * @param $alias
	 * @param array $data
	 * @param null $callback
	 */
	public static function dispatch($alias, $data = [], $callback = null)
	{
		foreach (static::$_handlers as $handler) {
			if (method_exists($handler, $alias . 'Handler')) {
				call_user_func([$handler, $alias . 'Handler'], $data, $callback);
			}
		}

		foreach (static::$_listeners as $listener) {
			if ($listener['event'] == $alias) {
				try {
					$listener['callback']($data);
				} catch (\Core\Exception\Exception $notImportant) {

				}
			}
		}
	}

	/**
	 * Subscribe for event and run callback function when event will be run
	 * @param $alias
	 * @param bool $callback
	 */
	public static function listen($alias, $callback = false)
	{
		static::$_listeners[] = [
			'event' => $alias,
			'callback' => $callback,
		];
	}
}
