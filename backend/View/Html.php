<?php

namespace Core\Traits\View;

use Core\Debug;

trait Html
{
	/**
	 * Generates style including link
	 * @return string
	 */
	public function loadCss($path)
	{
		$debug = Debug::getInstance();
		$debug->logResource('css', $path);
		return '<link href="' . '/' . $path . '" rel="stylesheet" type="text/css">';
	}

	/**
	 * Generates javascript including link
	 * @return string
	 */
	public function loadJs($path)
	{
		$debug = Debug::getInstance();
		$debug->logResource('js', $path);
		return '<script src="' . '/' . $path . '"></script>';
	}

	/**
	 * Generates javascript including link
	 * @return string
	 */
	public function loadPhtml($path, $vars = [])
	{
		$tplFilePath = \Core\App::get()->getAppPath() . '/' . $path;
		require_once($tplFilePath);
	}
}
