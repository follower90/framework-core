<?php

namespace Core;

trait Html
{
	/**
	 * Renders select box
	 * @param $optionsMap - requires key value params map
	 * @param array $params - associative array, id, class, name
	 * @param array $default - default key
	 * @return string
	 */
	public function select($optionsMap, $params = [], $default = [])
	{
		$result = '<select';

		if (isset($params['id'])) { $result .= ' id="' . $params['id'] . '"'; }
		if (isset($params['class'])) { $result .= ' class="' . $params['class'] . '"'; }
		if (isset($params['name'])) { $result .= ' name="' . $params['name'] . '"'; }

		$result .= '>';

		if (!empty($default)) {
			$optionsMap = array_merge($default, $optionsMap);
		}

		array_walk($optionsMap, function($name, $key) use (&$result) {
			$result .= '<option value="' . $key . '">' . $name .'</option>';
		});

		$result .= '</select>';
		return $result;
	}

	/**
	 * Generates style including link
	 * @return string
	 */
	public function loadCss($path)
	{
		return '<link href="' . $path . '" rel="stylesheet" type="text/css">';
	}

	/**
	 * Generates javascript including link
	 * @return string
	 */
	public function loadJs($path)
	{
		return '<script src="' . $path . '"></script>';
	}

	/**
	 * Generates javascript including link
	 * @return string
	 */
	public function loadPhtml($path)
	{
		return file_get_contents(\Core\App::get()->getAppPath() . $path);
	}
}
