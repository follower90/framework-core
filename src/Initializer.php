<?php

namespace Core;

use Core\Library\System;

class Initializer
{
	private $_debugParam;

	public function __construct()
	{
		session_start();

		$this->_setupDebugMode();
		$this->_setErrorHandlers();
	}

	public function run($entryPoint)
	{
		$app = new App($entryPoint);
		echo $app->init();

		System::showDebugConsole($this->_debugParam);
	}

	private function _setupDebugMode()
	{
		if (isset($_GET['cmsDebug'])) {
			$this->_debugParam = $_GET['cmsDebug'];
			switch ($this->_debugParam) {
				case 'on':
					setcookie('cmsDebug', 'on', time() + (31566000), '/');
					break;
				case 'off':
					setcookie('cmsDebug', 'on', time() - (31566000), '/');
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
