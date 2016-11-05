<?php

namespace Core;

class Router
{
	const NOT_AUTHORIZED = 'HTTP/1.1 401 Unauthorized';
	const NOT_FOUND_404 = 'HTTP/1.0 404 Not Found';
	const HEADER_MOVED_PERMANENTLY = 'HTTP/1.1 301 Moved Permanently';

	private static $_routes = [];
	private static $_controllerAliases = [];
	private static $_actionAliases = [];
	private static $_isApi = false;
	private static $_url;

	/**
	 * Returns controller and method for executing
	 * by requested URI
	 * @param $lib
	 * @return array|bool
	 */
	public static function getAction($lib)
	{
		self::_initUrlParams();

		if ($matchedAction  = self::_findMatches()) {
			return $matchedAction;
		}

		if ($autoDetectedAction = self::_autoDetect($lib)) {
			return $autoDetectedAction;
		}

		return [
			'controller' => 'Error',
			'action' => 'Index',
			'args' => [],
		];
	}
	
	private static function _findMatches()
	{
		foreach (static::$_routes as $route) {
			$match = static::_matches($route['url'], self::$_url, $route['args']);
			if ($match && self::get('request_method') == mb_strtoupper($route['method'])) {
				return [
					'controller' => isset($match['controller']) ? ucfirst($match['controller']) : $route['controller'],
					'action' => isset($match['action']) ? 'method' . ucfirst($match['action']) : $route['action'],
					'args' => $match,
				];
			}
		}
		
		return false;
	}

	/**
	 * Defines custom alias url for controller
	 * @param string $url first url part
	 * @param string $controller class name
	 */
	public static function alias($url, $controller)
	{
		self::$_controllerAliases[$url] = $controller;
	}

	/**
	 * Defines custom alias url for action
	 * @param string $url first url part
	 * @param string $controller class name
	 */
	public static function actionAlias($url, $action)
	{
		self::$_actionAliases[$url] = $action;
	}

	protected static function getUriParams()
	{
		$uriChunks = explode('/', self::$_url);
		array_shift($uriChunks);
		return $uriChunks;
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
			$uriChunks = static::getUriParams();
		}

		if (isset($uriChunks[0]) && isset(self::$_controllerAliases[$uriChunks[0]])) {
			$controller = self::$_controllerAliases[$uriChunks[0]];
		} else {
			$controller =  empty($uriChunks[0]) ? 'Index' : ucfirst($uriChunks[0]);
		}

		$action = empty($uriChunks[1]) ? 'Index' : ucfirst($uriChunks[1]);
		if (!empty($uriChunks[1]) && isset(self::$_actionAliases[$uriChunks[1]])) {
			$action = self::$_actionAliases[$uriChunks[1]];
		}

		$args = [];
		array_shift($uriChunks);

		if (is_array($uriChunks)) {
			$args = $uriChunks;
		}

		return self::_returnAction($lib, self::_sanitize($controller), self::_sanitize($action), $args);
	}

	private static function _returnAction($lib, $controller, $action, $args)
	{
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
			$i++;

			$value = isset($args[$i]) ? $args[$i] : null;
			$uriParams[$key] = $value;
		}

		return array_merge($uriParams, $_GET, $_POST);
	}

	/**
	 * Removes slashes from Controller path
	 * @param type $string
	 * @return type
	 */
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
	public static function register($request, $controller, $action, $params = [])
	{
		static::$_routes[] = [
			'url' => $request[0],
			'method' => $request[1],
			'controller' => ucfirst($controller),
			'action' => ucfirst($action),
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
		exit;
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
			'remote_addr' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'request_method' => $_SERVER['REQUEST_METHOD'],
		];

		if (isset($_SERVER['HTTP_REFERER'])) {
			$serverParams['referer'] = $_SERVER['HTTP_REFERER'];
		}

		return isset($serverParams[$param]) ? $serverParams[$param] : false;
	}

	/**
	 * Checks match requested URI with registered custom routes
	 * @param $route
	 * @param $url
	 * @return bool
	 */
	private static function _matches($route, $url, $args)
	{
		preg_match_all($route, $url, $matches);
		$params = [];

		if ($matches[0]) {
			if (isset($matches[1])) {
				for ($i = 1; $i < sizeof($matches); $i++) {
					$params[$args[$i - 1]] = $matches[$i][0];
				}

				return $params;
			}

			return true;
		}

		return false;
	}

	/**
	 * Sends http headers
	 * @param $headers
	 */
	public static function sendHeaders($headers = [])
	{
		foreach ($headers as $header) {
			header($header);
		}
	}

	/**
	 * Registers route
	 * @param string $httpMethod
	 * @param string $pattern
	 * @param string $action
	 * @return \Core\Router
	 */
	public function route($httpMethod, $pattern, $action)
	{
		$action = explode('#', $action);
		$arguments = $this->_parseGetParams($pattern);
		self::register([$pattern, $httpMethod], $action[0], $action[1], $arguments);

		return $this;
	}

	/**
	 * Returns params from matched pattern
	 * @param string $pattern
	 * @return array
	 */
	private function _parseGetParams($pattern)
	{
		$params = [];
		preg_match_all('/\:(\w+)/', $pattern, $params);

		$routeParts = explode('/', $pattern);
		$urlParts = explode('/', self::get('uri'));

		$arguments = [];

		foreach ($routeParts as $num => $part) {
			foreach ($params[0] as $i => $param) {
				if ($param == $part) {
					$param = $params[1][$i];
					$arguments[$param] = $urlParts[$num];
				}
			}
		}

		return $arguments;
	}
}
