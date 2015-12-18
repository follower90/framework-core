<?php

namespace Core;

use \Core\Library\System;
/**
 * Class App
 * Main application class
 * It sets user, entry point, requests router params, debug mode, error handlers
 * and launches controller
 *
 * @package Core
 */
class App
{
	/**
	 * Entry point object
	 * @var EntryPoint
	 */
	private $_entryPoint;

	/**
	 * Debug mode on/off flag
	 * @var Boolean
	 */
	private $_debugParam;

	/**
	 * Path to vendor folder
	 * @var Boolean
	 */
	private $_vendorPath;

	/**
	 * Root project directory
	 * @var string
	 */
	private $_appPath;

	/**
	 * Authorized user
	 * @var bool|\Core\Object
	 */
	private static $_user = false;

	/**
	 * This instance
	 * @var bool|\Core\App
	 */
	private static $_instance = false;

	/**
	 * Sets application root path
	 * and entry point
	 *
	 * @param EntryPoint $entryPoint
	 */
	public function __construct(EntryPoint $entryPoint)
	{
		$this->_entryPoint = $entryPoint;
		$this->_appPath = \getcwd();

		if ($siteUrl = Config::get('site.url')) {
			$this->_appPath = str_replace($siteUrl, '', $this->_appPath);
		}

		static::$_instance = $this;
	}

	/**
	 * Returns App instance
	 */
	public static function get()
	{
		if (static::$_instance) {
			return static::$_instance;
		}

		throw new \Core\Exception\Exception("App is not initialized yet");
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
	 *
	 * @throws \Exception
	 */
	public function run()
	{
		Session::init();
		date_default_timezone_set('Europe/Kiev');

		$this->_setupDebugMode();
		$this->_setErrorHandlers();
		$this->_setFileIncludeHandler();
		$this->_setBackTraceHandler();

		$action = Router::getAction($this->_entryPoint->getLib());

		$class = $this->_entryPoint->getLib() . '\\' . $action['controller'];
		$method = 'method' . ucfirst($action['action']);

		if (!class_exists($class)) {
			throw new \Core\Exception\Exception('Controller: ' . $action['controller'] . ' was not found');
		}

		if (!method_exists($class, $method)) {
			throw new \Core\Exception\Exception('Method: ' . $action['action'] . ' was not found');
		}

		$controller = new $class();

		echo $this->_entryPoint->output(
			call_user_func_array([$controller, 'run'], [$method, array_merge($action['args'], $controller->request())])
		);
	}

	/**
	 * Register function calls for backtrace
	 */
	private function _setBackTraceHandler()
	{
		declare(ticks=1);

		register_tick_function(function() {
			$call = debug_backtrace()[1];
			$classesExclusions = [
				'', 'Core\Debug', 'Core\Orm', 'Core\Database\QueryBuilder', 'Core\Database\PDO',
				'Core\Object', 'Core\ObjectConfig', 'Core\Collection', 'Core\OrmMapper', 'Core\OrmCache', 'Core\App',
			];

			$methodsExclusions = [
				'getConfig',
			];

			if (isset($call['class'], $call['function'], $call['file'], $call['line']) &&
				!in_array($call['class'], $classesExclusions) &&
				!in_array($call['function'], $methodsExclusions)
			) {
				$debug = Debug::getInstance();
				$debug->logTrace([
					'function' => $call['function'],
					'class' => $call['class'],
					'file' => $call['file'],
					'line' => $call['line'],
				]);
			}
		}, true);
	}

	/**
	 * Sets authorized user globally
	 *
	 * @param \Core\Object $user
	 */
	public static function setUser(Object $user)
	{
		static::$_user = $user;
	}

	/**
	 * Get root path of vendor in current entry point
	 * @param string $path
	 * @return true
	 */
	public function setVendorPath($path)
	{
		$this->_vendorPath = $path;
		return true;
	}

	/**
	 * Get root path of vendor in current entry point
	 * @return string path
	 */
	public function getVendorPath()
	{
		return $this->_vendorPath;
	}

	/**
	 * Get root path of application at server
	 * @return string
	 */
	public function getAppPath()
	{
		return $this->_appPath;
	}

	/**
	 * Get authorized user object
	 * @return bool|\Core\Object
	 */
	public static function getUser()
	{
		return static::$_user;
	}

	/**
	 * Setups debug-mode cookie
	 * based on GET param
	 */
	private function _setupDebugMode()
	{
		if (isset($_GET['debug'])) {
			$this->_debugParam = $_GET['debug'];
			switch ($this->_debugParam) {
				case 'on':
					Cookie::set('debug', 'on');
					break;

				case 'off':
					Cookie::remove('debug');
					break;
			}
		}
	}

	/**
	 * Gets debugger instance, gets all logged data
	 * and renders template with debug console
	 *
	 * @param string $debug on/off
	 * @todo refactor for allowed IPs configuration
	 */
	public function showDebugConsole($debug = 'on')
	{
		if ($debug == 'on' || Cookie::get('debug') && $debug != 'off') {

			/*if (Router::get('remote_addr') != '127.0.0.1') {
				return;
			}*/

			$debug = Debug::getInstance();
			$data = [];
			$data['instanceHash'] = hash('crc32', rand(0,100));
			$data['phpErrors'] = $debug->getPhpErrors();
			$data['frameworkErrors'] = $debug->getFrameworkErrors();
			$data['dumps'] = $debug->getDumps();
			$data['queries'] = $debug->getQueriesLog();
			$data['files'] = $debug->getFilesLog();
			$data['trace'] = $debug->getTrace();

			$view = new View();
			echo $view->render($this->_appPath . '/vendor/follower/core/tpl/debug.phtml', $data);
		}
	}

	/**
	 * Registering handler function for
	 * logging included files into debugger
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
}
