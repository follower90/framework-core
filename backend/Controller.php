<?php
namespace Core;

use Core\Database\PDO;

class Controller
{
	protected $db;
	protected $view;
	protected $settings;

	function __construct()
	{
		$this->db = PDO::getInstance();
		$this->view = new View();
	}

	function params($key = false)
	{
		$uri = explode('/', $_SERVER['REQUEST_URI']);
		$params = [];

		for ($i = 1; $i < count($uri); ) {
			$params[$uri[$i]] = $uri[++$i];
			++$i;
		}

		if ($key) {
			return $params[$key];
		}

		return $params;
	}

	public function request($key = false)
	{
		$request = array_merge($_POST, $_GET);

		if ($key) {
			return isset($request[$key]) ? $request[$key] : false;
		} else {
			return $request;
		}
	}

	protected function callApi($apiPath, $arguments)
	{
		$apiPath = explode(':', $apiPath);

		$class = '\\' . str_replace('.', '\\', $apiPath[0]);
		$method = 'method' . ucfirst($apiPath[1]);

		$apiController = new $class();

		if (method_exists($apiController, $method)) {
			return call_user_func([$apiController, $method], $arguments);
		} else {
			throw new \Exception('Error');
		}
	}
}
