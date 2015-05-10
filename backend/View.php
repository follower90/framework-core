<?php
namespace Core;

class View {

	use Html;
	
	private $_templateOptions = [];
	private static $_num;

	public function setOptions($data)
	{
		$this->_templateOptions = array_merge($this->_templateOptions, $data);
	}

	public function setOption($key, $value)
	{
		$this->_templateOptions[$key] = $value;
	}

	public function render($tpl, $vars = [])
	{
		ob_start();
		include $tpl;

		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}
}
