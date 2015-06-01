<?php

namespace Core;

class Router
{

	private static $_routes;

	public static function getAction($lib)
	{
		$url = explode('?', $_SERVER['REQUEST_URI'])[0];

		if (strpos($url, '/api/') === 0) {
			$url = str_replace('/api/', '', $url);
		}

		if ($url == '/api.php') {
			$url = $_GET['method'];
		}

		foreach (static::$_routes as $route) {
			if (static::_matches($route['url'], $url) /*&& mb_strtolower($_SERVER['REQUEST_METHOD']) == $route['method']*/) {
				return [
					'controller' => $route['controller'],
					'action' => $route['action'],
					'args' => $route['args'],
				];
			}
		}

		if ($action = self::_autoDetect($lib)) {
			return $action;
		}

		return [
			'controller' => 'Error',
			'action' => 'Index',
			'args' => [],
		];
	}

	protected static function _autoDetect($lib)
	{
		$url = explode('?', $_SERVER['REQUEST_URI'])[0];
		$isApi = false;

		if (strpos($url, '/api/') === 0) {
			$url = str_replace('/api/', '', $url);
			$isApi = true;
		}

		if ($url == '/api.php') {
			$url = $_GET['method'];
			$isApi = true;
		}

		if ($isApi) {
			$uriChunks = explode('.', $url);
		} else {
			$uriChunks = explode('/', $url);
			array_shift($uriChunks);
		}

		$controller = $uriChunks[0] ? ucfirst($uriChunks[0]) : 'Index';
		$action = $uriChunks[1] ? ucfirst($uriChunks[1]) : 'Index';

		$args = array_shift(array_shift($uriChunks));

		if (method_exists($lib . '\\' . $controller, 'method' . $action)) {
			return [
				'controller' => $controller,
				'action' => $action,
				'args' => array_merge($args, $_GET, $_POST),
			];
		}

		return false;
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

	public static function redirect($url, $headers = [])
	{
		header('Location: ' . $url);
	}

	private static function _matches($route, $url)
	{
		$routeChunks = explode('/', $route);
		$urlChunks = explode('/', $url);

		for ($i = 0; $i < count($urlChunks); $i++) {
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