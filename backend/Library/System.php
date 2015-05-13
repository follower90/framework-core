<?php

namespace Core\Library;

use Core\Debug;

class System
{
	public static function vardump($data, $level = 0)
	{
		if (empty($data)) {
			echo '<i>(empty)</i><br/>';
			return;
		}

		if (!is_array($data)) {
			echo $data;
		}

		foreach ($data as $key => $sub) {
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
