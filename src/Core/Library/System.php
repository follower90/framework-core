<?php

namespace Core\Library;

use Core\Debug;
use Core\View;

class System
{
	public static function showDebugConsole($debug = 'on')
	{
		if ($debug == 'on' || isset($_COOKIE['cmsDebug']) && $debug != 'off') {
			$debug = Debug::getInstance();

			$data = [];
			$data['instanceHash'] = rand(0,100);
			$data['phpErrors'] = $debug->getPhpErrors();
			$data['cmsErrors'] = $debug->getCmsErrors();
			$data['cmsDumps'] = $debug->getCmsDumps();
			$data['queries'] = $debug->getQueriesLog();
			$data['files'] = $debug->getFilesLog();

			$view = new View();
			echo $view->Render('public/templates/debug.phtml', $data);
		}
	}

	public static function vardump($array, $level = 0)
	{
		if (empty($array)) {
			echo '<i>(empty)</i><br/>';
			return;
		}

		foreach ($array as $key => $sub) {
			echo str_repeat('.', $level) . ' <i>[' . $key . ']</i> -> ';
			if (!is_array($sub)) {
				echo '\'' . htmlspecialchars($sub) . '\'<br/>';
			} else {
				echo '<br/>';
				self::vardump($sub, ++$level);
				$level--;
			}
		}
	}

	public static function dump()
	{
		$debug = Debug::getInstance();
		$vars = func_get_args();

		foreach ($vars as $var) {
			$debug->logDump($var);
		}
	}
}
