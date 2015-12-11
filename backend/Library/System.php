<?php

namespace Core\Library;

use Core\Debug;

class System
{
	public static function vardump($data, $level = 0)
	{
		$keyColor = '#5E865E';
		$valueColor = '#B32121';
		if (empty($data)) {
			echo '<i style="color:' . $valueColor . ';">(empty)</i><br/>';
			return;
		}

		if (!is_array($data)) {
			echo $data;
		}

		foreach ($data as $key => $sub) {
			echo str_repeat('.', $level) . ' <i style="color:' . $keyColor . ';">[' . $key . ']</i> -> ';
			if (!is_array($sub)) {
				echo '<span style="color:' . $valueColor . ';">\'' . htmlspecialchars($sub) . '</span>\'<br/>';
			} else {
				echo '<br/>';
				self::vardump($sub, $level + 1);
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
