<?php
namespace Core;

class View {

	use Html;
	
	private $_templateOptions = [];
	private $_defaultPath = false;

	/**
	 * Template params setter
	 * @param $data
	 */
	public function setOptions($data)
	{
		$this->_templateOptions = array_merge($this->_templateOptions, $data);
	}

	/**
	 * Single template param setter
	 * @param $key
	 * @param $value
	 */
	public function setOption($key, $value)
	{
		$this->_templateOptions[$key] = $value;
	}

	/**
	 * Renders template with vars
	 * @param $tpl
	 * @param array $vars (do not rename it!)
	 * @return string
	 */
	public function render($tpl, $vars = [])
	{
		ob_start();

		if ($this->_defaultPath) {
			$tpl = App::get()->getAppPath() . $this->_defaultPath . '/' . $tpl;
		}

		include $tpl;

		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	/**
	 * Set path to folder with templates, etc.
	 * @param $path path to public folder
	 */
	public function setDefaultPath($path)
	{
		$this->_defaultPath = $path;
	}

	/**
	 * Includes css/js/etc. file into template
	 * Root path is "vendor path" for current entry point
	 * Look into Html trait for setup concrete loading methods
	 * @param $tpl
	 * @param array $vars
	 * @return string
	 */
	public function load($type, $path)
	{
		if(method_exists($this, 'load' . ucfirst($type))) {
			echo call_user_func([$this, 'load' . ucfirst($type)], $this->_defaultPath . $path) . PHP_EOL;
		} else {
			throw new \Exception('Unsupported file type');
		}
	}
}
