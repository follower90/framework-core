<?php

namespace Core;

class App
{
	private $_entryPoint;

	public function __construct($entryPoint)
	{
		$this->_entryPoint = $entryPoint;
	}

	public function init()
	{
		$project = Config::get('project');
		$action = Router::getAction();

		$class = '\\' . $project . '\\' . $this->_entryPoint->getType() . '\\' . $action['controller'];
		$method = 'method' . ucfirst($action['action']);

		$controller = new $class();

		if (method_exists($class, $method)) {
			return call_user_func([$controller, $method]);
		} else {
			throw new \Exception('Error');
		}
	}

	public static function run($entryPoint)
	{
		date_default_timezone_set('Europe/Kiev');

		$app = new Initializer();
		$app->run($entryPoint);
	}
}
