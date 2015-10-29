<?php

namespace Core;

class Router
{

	const NOT_AUTHORIZED = 'HTTP/1.1 401 Unauthorized';
	const NOT_FOUND_404 = 'HTTP/1.0 404 Not Found';

	private static $_routes = [];
	private static $_aliases = [];
	private static $_url;
	private static $_isApi = false;

	/**
	 * Returns controller and method for executing
	 * by requested URI
	 * @param $lib
	 * @return array|bool
	 */
	public static function getAction($lib)
	{
		self::_initUrlParams();

		foreach (static::$_routes as $route) {
			if (static::_matches($route['url'], self::$_url) && mb_strtolower($_SERVER['REQUEST_METHOD']) == $route['method']) {
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

	/**
	 * Defines custom alias url for controller
	 * @param string $url first url part
	 * @param string $controller class name
	 */
	public static function alias($url, $controller)
	{
		self::$_aliases[$url] = $controller;
	}

	/**
	 * Autodetect appropriate route
	 * @param $lib
	 * @return array|bool
	 */
	protected static function _autoDetect($lib)
	{
		if (self::$_isApi) {
			$uriChunks = explode('.', self::$_url);
		} else {
			$uriChunks = explode('/', self::$_url);
			array_shift($uriChunks);
		}

		if (isset(self::$_aliases[$uriChunks[0]])) {
			$controller = self::$_aliases[$uriChunks[0]];
		} else {
			$controller =  empty($uriChunks[0]) ? 'Index' : ucfirst($uriChunks[0]);
		}

		$action = empty($uriChunks[1]) ? 'Index' : ucfirst($uriChunks[1]);

		$args = [];
		array_shift($uriChunks);

		if (is_array($uriChunks)) {
			$args = $uriChunks;
		}

		$action = self::_sanitize($action);
		$controller = self::_sanitize($controller);

		if (method_exists($lib . '\\' . $controller, 'method' . $action)) {
			return [
				'controller' => $controller,
				'action' => $action,
				'args' => self::getArgs($args),
			];
		}

		return false;
	}

	/**
	 * Combines Uri params with GET and POST data
	 * @param $args
	 * @return array
	 */
	protected static function getArgs($args = [])
	{
		$uriParams = [];

		for ($i = 0; $i < sizeof($args); $i++) {
			$key = $args[$i];
			$value = $args[++$i];
			$uriParams[$key] = $value;
		}

		return array_merge($uriParams, $_GET, $_POST);
	}

	protected static function _sanitize($string)
	{
		return str_replace(['/'], '', $string);
	}

	/**
	 * Writes requested uri, based on site.url
	 * and 'isApi' = true, if Api request
	 * @return array
	 */
	protected static function _initUrlParams()
	{
		$url = explode('?', static::get('uri'))[0];

		if ($rootPath = Config::get('site.url')) {
			$url = preg_replace('/\/' . $rootPath . '/', '', $url, 1);
		}

		if (strpos($url, '/api/') === 0) {
			$url = str_replace('/api/', '', $url);
			self::$_isApi = true;
		}

		if ($url == '/api.php') {
			$url = $_GET['method'];
			self::$_isApi = true;
		}

		self::$_url = $url;
	}

	/**
	 * Register custom route
	 * @param $request
	 * @param $controller
	 * @param $action
	 * @param $params
	 */
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

	/**
	 * Simple redirect to URI
	 * Accepts array of custom headers
	 * @param $url
	 * @param array $headers
	 */
	public static function redirect($url, $headers = [])
	{
		static::sendHeaders($headers);
		header('Location: ' . $url);
	}

	/**
	 * Get Server Request params
	 * @param string $param
	 * @return string|bool
	 */
	public static function get($param)
	{
		$serverParams = [
			'name' => $_SERVER['SERVER_NAME'],
			'host' => $_SERVER['HTTP_HOST'],
			'uri' => $_SERVER['REQUEST_URI'],
			'referer' => $_SERVER['HTTP_REFERER'],
			'remote_addr' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
		];

		return isset($serverParams[$param]) ? $serverParams[$param] : false;
	}

	/**
	 * Checks match requested URI with registered custom routes
	 * @param $route
	 * @param $url
	 * @return bool
	 */
	private static function _matches($route, $url)
	{
		$routeChunks = explode('/', $route);
		$urlChunks = explode('/', $url);

		for ($i = 0; $i < count($urlChunks); $i++) {
			if ($routeChunks[$i] == $urlChunks[$i] || $routeChunks[$i] == '*') {
				continue;
			} elseif ($i == 0 && isset(self::$_aliases[$urlChunks[$i]])) {
				continue;
			}

			if ($routeChunks[$i] == '+' && $urlChunks[$i]) {
				continue;
			}

			return false;
		}

		return true;
	}

	/**
	 * Sends http headers
	 * @param $headers
	 */
	public static function sendHeaders($headers = []) {
		foreach ($headers as $header) {
			header($header);
		}
	}
}
