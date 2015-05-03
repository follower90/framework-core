<?php

namespace Core;

class Router
{

	private static $_routes;

	public static function getAction()
	{
		$url = explode('?', $_SERVER['REQUEST_URI'])[0];

		if (strpos($url, '/api/') == 0) {
			$url = str_replace('/api/', '', $url);
		}

		foreach (static::$_routes as $route) {
			if (static::_matches($route['url'], $url) && mb_strtolower($_SERVER['REQUEST_METHOD']) == $route['method']) {
				return [
					'controller' => $route['controller'],
					'action' => $route['action'],
					'args' => $route['args'],
				];
			}
		}

		return [
			'controller' => 'Error',
			'action' => 'Index',
			'args' => [],
		];
	}

	public static function register($request, $controller, $action, $params)
	{
		static::$_routes[] = [
			'url' => $request[0],
			'method' => $request[1],
			'controller' => $controller,
			'action' => $action,
			'args' => $params,
		];
	}

	private static function _matches($route, $url)
	{
		$routeChunks = explode('/', $route);
		$urlChunks = explode('/', $url);

		for ($i = 0; $i < count($routeChunks); $i++) {
			if ($routeChunks[$i] == $urlChunks[$i] || $routeChunks[$i] == '*') {
				continue;
			}

			if ($routeChunks[$i] == '+' && $urlChunks[$i]) {
				continue;
			}

			return false;
		}

		return true;
	}
}