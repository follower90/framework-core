<?php

namespace Core;

use Core\Library\System;

class App
{
	private $_entryPoint;
	private $_debugParam;
	private $_appPath;

	private static $_user = false;

	public function __construct($entryPoint)
	{
		$this->_appPath = \getcwd();
		$this->_entryPoint = $entryPoint;
	}

	public function __destruct()
	{
		if ($this->_entryPoint->debug()) {
			$this->showDebugConsole($this->_debugParam);
		}
	}

	public function run()
	{
		date_default_timezone_set('Europe/Kiev');
		session_start();

		$this->_setupDebugMode();
		$this->_setErrorHandlers();
		$this->_setFileIncludeHandler();

		$action = Router::getAction();

		$class = $this->_entryPoint->getLib() . '\\' . $action['controller'];
		$method = 'method' . ucfirst($action['action']);

		if (!class_exists($class)) {
			throw new \Exception('Controller was not found');
		}

		if (!method_exists($class, $method)) {
			throw new \Exception('Method was not found');
		}

		$controller = new $class();

		echo $this->_entryPoint->output(
			call_user_func([$controller, $method], $controller->request())
		);
	}

	public static function setUser($user)
	{
		static::$_user = $user;
	}

	public static function getUser()
	{
		return static::$_user;
	}

	private function _setupDebugMode()
	{
		if (isset($_GET['cmsDebug'])) {
			$this->_debugParam = $_GET['cmsDebug'];
			switch ($this->_debugParam) {
				case 'on':
					Cookie::set('cmsDebug', 'on');
					break;

				case 'off':
					Cookie::remove('cmsDebug');
					break;
			}
		}
	}

	public function showDebugConsole($debug = 'on')
	{
		if ($debug == 'on' || Cookie::get('cmsDebug') && $debug != 'off') {
			$debug = Debug::getInstance();

			$data = [];
			$data['instanceHash'] = hash('crc32', rand(0,100));
			$data['phpErrors'] = $debug->getPhpErrors();
			$data['cmsErrors'] = $debug->getCmsErrors();
			$data['cmsDumps'] = $debug->getCmsDumps();
			$data['queries'] = $debug->getQueriesLog();
			$data['files'] = $debug->getFilesLog();

			$view = new View();
			echo $view->render($this->_appPath . '/vendor/follower/core/tpl/debug.phtml', $data);
		}
	}

	private function _setFileIncludeHandler()
	{
		spl_autoload_register(function($file) {
			$debug = Debug::getInstance();
			$debug->logFile($file);
		}, true, true);
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

				$this->showDebugConsole();
			}
		});
	}
}
