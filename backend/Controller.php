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

	public function run($method, $args)
	{
		return call_user_func([$this, $method], $args);
	}

	public function request($key = false)
	{
		$request = array_merge($_POST, $_GET);

		if ($key) {
			return isset($request[$key]) ? $request[$key] : false;
		}

		return $request;
	}

	protected function execute($apiPath, $arguments)
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
