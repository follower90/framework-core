<?php

namespace Core\Library;

use Core\Exception\Exception;

class File
{
	public static function save($filename, $data)
	{
		$root = \Core\App::get()->getAppPath();
		return file_put_contents($root . '/' . $filename, $data);
	}

	static public function upload($filename, $name = false)
	{
		if (!$name) $name = $filename;
		$root = \Core\App::get()->getAppPath();
		$filename = $root . '/' . $filename;

		if (!file_exists($filename)) {
			throw new Exception('File ' . $filename . ' does not exist');
		}

		header("Content-Length: " . filesize($filename));
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $name);

		readfile($filename);
	}
}