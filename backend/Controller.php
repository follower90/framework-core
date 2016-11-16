<?php
namespace Core;

use Core\Database\PDO;

class Controller
{
	protected $db;
	protected $view;
	protected $settings;
	protected $user;

	/**
	 * Assigns PDO Mysql connection to protected variable
	 * Assigns View object for templates rendering
	 */
	public function __construct()
	{
		$this->db = PDO::getInstance();
		$this->view = new View();
		$this->user = App::getUser();
	}

	/**
	 * Controllers run wrapper
	 * for error catching
	 * @param $method
	 * @param $args
	 * @return mixed
	 */
	public function run($method, $args)
	{
		try {
			return call_user_func([$this, $method], $args);
		} catch (\Exception $e) {
			return 'Catchable error detected: ' . $e->getCode() . ' - ' . $e->getMessage();
		}
	}

	/**
	 * Helper method for get POST and GET request variables
	 * @param bool $key
	 * @return array|bool
	 */
	public function request($key = false)
	{
		$request = array_merge($_POST, $_GET);

		if ($key) {
			return isset($request[$key]) ? $request[$key] : false;
		}

		return $request;
	}

	/**
	 * Api/Controller method executor
	 * For running one controller's method from another and avoid code duplication
	 * @param $apiPath
	 * @param $arguments
	 * @return mixed
	 * @throws \Exception
	 */
	protected function execute($apiPath, $arguments)
	{
		$apiPath = explode(':', $apiPath);

		$class = '\\' . str_replace('.', '\\', $apiPath[0]);
		$method = 'method' . ucfirst($apiPath[1]);

		$apiController = new $class();

		if (method_exists($apiController, $method)) {
			return call_user_func([$apiController, $method], $arguments);
		} else {
			throw new \Core\Exception\Exception('Error');
		}
	}
}
