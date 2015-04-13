<?php

namespace Core;

class Event
{
	private static $_handlers = [];
	private static $_listeners = [];

	public static function registerHandler(EventHandler $handler)
	{
		if (!in_array($handler, static::$_handlers)) {
			static::$_handlers[] = $handler;
		}
	}

	public static function dispatch($alias, $data = [], $callback = '')
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
				} catch (\Exception $notImportant) {

				}
			}
		}
	}

	public static function listen($alias, $callback = false)
	{
		static::$_listeners[] = [
			'event' => $alias,
			'callback' => $callback,
		];
	}
}
