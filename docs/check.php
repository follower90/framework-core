<?php

require_once('vendor/autoload.php');

class Documentor
{
	private $dir;

	public function __construct($folder)
	{
		$this->dir = $folder;
	}

	public function run()
	{
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($this->dir),
			RecursiveIteratorIterator::SELF_FIRST);

		foreach ( $iterator as $fileInfo ) {
			if (!$fileInfo->isDir() && $fileInfo) {
				if ($fileInfo->getExtension() == 'php') {
					$this->process_file($fileInfo);
				}
			}
		}
	}

	private function process_file($fileInfo)
	{
		$path = $fileInfo->getPathName();
		$nameArr = explode('/', $path);

		$name = '\\Core\\';
		$push = false;

		foreach ($nameArr as $arr) {

			if ($arr == 'backend') {
				$push = true;
			} else if ($push) {
				$push = true;

				if (substr($arr, -3) == 'php') {
					$name .= substr($arr, 0, -4);
				} else {
					$name .= $arr . '\\';
				}
			}
		}

		//dont push objects
		if (substr($name, 0, 12) == '\\Core\\Object') {
			return false;
		}

		if (class_exists($name) 
			|| trait_exists($name)
			|| interface_exists($name)) {
				$this->analyzeClass($name);
		} else {
			echo 'SHIT: ' . $name . PHP_EOL . PHP_EOL;
		}
	}

	private function analyzeClass($name)
	{
		$reflexionClass = new \ReflectionClass($name);
		$path = getcwd() . '/vendor/follower/core/docs' . str_replace('\\', '/', $name) . '.md';

		if (!is_dir(dirname($path))) {
			$t = mkdir(dirname($path), 0777, true);
		}

		//if (!file_exists($path)) {
			file_put_contents($path, $reflexionClass);
		//}

	}
}

$documentation = new Documentor('vendor/follower/core/backend/');
$documentation->run();
