<?php

namespace Core;

use Core\Library\System;

class App
{
	private $_entryPoint;
	private $_debugParam;

	public function __construct($entryPoint)
	{
		$this->_entryPoint = $entryPoint;
	}

	public function __destruct()
	{
		System::showDebugConsole($this->_debugParam);
	}

	public function run()
	{
		date_default_timezone_set('Europe/Kiev');
		session_start();

		$this->_setupDebugMode();
		$this->_setErrorHandlers();

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

	private function _setupDebugMode()
	{
		if (isset($_GET['cmsDebug'])) {
			$this->_debugParam = $_GET['cmsDebug'];
			switch ($this->_debugParam) {
				case 'on':
					Cookie::set('cmsDebug', 'on', 31566000);
					break;

				case 'off':
					Cookie::set('cmsDebug', 'on', -31566000);
					break;
			}
		}
	}

	private function _setErrorHandlers()
	{
		set_error_handler(function($number, $string, $file, $line) {
			$debug = Debug::getInstance();
			$debug->logPhpError([
				'num' => $number,
				'error' => $string,
				'file' => $file,
				'line' => $line,
			]);
		});

		register_shutdown_function(function() {
			$error = error_get_last();
			if (in_array($error['type'], [E_ERROR, E_PARSE])) {
				$debug = Debug::getInstance();
				$debug->logPhpError([
					'num' => $error['type'],
					'error' => $error['message'],
					'file' => $error['file'],
					'line' => $error['line'],
				]);

				System::showDebugConsole();
			}
		});
	}
}
