<?php

namespace Core\Library;

class Dir
{

	static function remove($dir)
	{
		if ($objs = glob($dir . "/*")) {
			foreach ($objs as $obj) {
				is_dir($obj) ? Dir::remove($obj) : unlink($obj);
			}
		}
		if (is_dir($dir)) rmdir($dir);
	}

	static function clear($path)
	{
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle)))
				if ($file != "." && $file != "..") unlink($path . $file);
			closedir($handle);
		}
	}

	static function getDirectoriesList($path)
	{
		$list_dir = [];
		$dir = opendir($path);
		while ($file_name = readdir($dir)) {
			clearstatcache();

			if (is_dir($path . $file_name) && $file_name != '.' && $file_name != '..') {
				array_push($list_dir, $file_name);
			}
		}

		return $list_dir;
	}

	static function getFilesList($dir)
	{
		$list_file = [];
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if ($file != '.' && $file != '..' && !is_dir($dir . $file)) {
						$time = date("Y-m-d H:i:s", filemtime($dir . $file));
						array_push($list_file, ['name' => $file, 'time' => $time, 'path' => $dir . $file]);
					}
				}

				closedir($dh);
			}
		}

		return $list_file;
	}
}
