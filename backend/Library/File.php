<?php

namespace Core\Library;

use Core\Exception\Exception;

class File
{
	public static function put($filename, $data)
	{
		$root = \Core\App::get()->getAppPath();
		$dir = dirname($root . $filename);

		if (!is_dir($dir)) {
			mkdir($dir, 0755, true);
		}
		return file_put_contents($root . $filename, $data);
	}

	public static function upload($filename, $name = false)
	{
		if (!$name) $name = $filename;
		if (!file_exists($filename)) {
			throw new Exception('File ' . $filename . ' does not exist');
		}

		header("Content-Length: " . filesize($filename));
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $name);

		echo readfile($filename);
	}

	public static function delete($path)
	{
		$root = \Core\App::get()->getAppPath();
		return unlink($root . $path);
	}

	public static function request()
	{
		return $_FILES;
	}

	public static function saveUploadedFile($tmpName, $path)
	{
		$dir = dirname(\Core\App::get()->getAppPath() . $path);
		if (!is_dir($dir)) {
			mkdir($dir);
		}

		move_uploaded_file($tmpName, \Core\App::get()->getAppPath() . $path);
	}

	public static function get($path)
	{
		$root = \Core\App::get()->getAppPath();
		return file_get_contents($root . $path);
	}
}
