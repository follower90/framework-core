<?php

namespace Core;

class App
{
	private $_entryPoint;
	private $_debugParam;
	private $_appPath;

	private static $_user = false;

	/**
	 * Sets entry point object
	 * and application root path
	 * @param EntryPoint $entryPoint
	 */
	public function __construct(EntryPoint $entryPoint)
	{
		$this->_appPath = \getcwd();
		$this->_entryPoint = $entryPoint;
	}

	/**
	 * Show debugger console
	 * in the end of application life cycle
	 */
	public function __destruct()
	{
		if ($this->_entryPoint->debug()) {
			$this->showDebugConsole($this->_debugParam);
		}
	}

	/**
	 * Core application run method
	 * Setups debugger, file including and error handling
	 * Requests route and calls API/Controller
	 * @throws \Exception
	 */
	public function run()
	{
		Session::init();
		$this->_setTimeZone('Europe/Kiev');

		$this->_setupDebugMode();
		$this->_setErrorHandlers();
		$this->_setFileIncludeHandler();

		$action = Router::getAction($this->_entryPoint->getLib());

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
			call_user_func_array([$controller, 'run'], [$method, $controller->request()])
		);
	}

	/**
	 * Sets authorized user globally
	 * @param $user
	 */
	public static function setUser($user)
	{
		static::$_user = $user;
	}

	/**
	 * Get authorized user object
	 * @return bool
	 */
	public static function getUser()
	{
		return static::$_user;
	}

	/**
	 * Setups debug-mode cookie
	 * based on GET param
	 * @todo need to extend for debug mode security (allowed IPs, or developer hash key)
	 */
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

	/**
	 * Gets debugger instance, gets all logged data
	 * and renders template with debug console
	 * @param string $debug
	 */
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

	/**
	 * Logs included files for debug console
	 */
	private function _setFileIncludeHandler()
	{
		spl_autoload_register(function($file) {
			$debug = Debug::getInstance();
			$debug->logFile($file);
		}, true, true);
	}

	/**
	 * Logs PHP warnings, notices and fatal errors to debug console
	 * Shows debug console immediately in case of fatal error
	 */
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

	/**
	 * Set default timezone wrapper
	 * @param $alias
	 */
	private function _setTimeZone($alias)
	{
		date_default_timezone_set($alias);
	}
}
