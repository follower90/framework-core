<?php
namespace Core;

class View {

	use Html;
	
	private $_templateOptions = [];
	private $_defaultPath = false;

	private $_styles;
	private $_scripts;

	private $_noticeObject = '\Core\Notice';
	private $_notices = [];

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
	 * Return resources batch by type
	 * @param string $type
	 */
	public function loadResources($type = false)
	{
		switch ($type) {
			case 'css':
				return $this->_styles;
				break;

			case 'js':
				return $this->_scripts;
				break;
			default:
				return '';
				break;
		}
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

		if (isset($vars['styles'])) {
			$this->_styles = $this->_prepare('css', $vars['styles']);
		}

		if (isset($vars['scripts'])) {
			$this->_scripts = $this->_prepare('js', $vars['scripts']);
		}

		include $tpl;

		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	/**
	 * Set path to folder with templates, etc.
	 * @param $path string to public folder
	 */
	public function setDefaultPath($path)
	{
		$this->_defaultPath = $path;
	}

	/**
	 * Includes css/js/etc. file into template
	 * Root path is "vendor path" for current entry point
	 * Look into Html trait for setup concrete loading methods
	 * @param $type
	 * @param string $vars
	 * @return string
	 */
	public function load($type, $path)
	{
		if(method_exists($this, 'load' . ucfirst($type))) {
			return call_user_func([$this, 'load' . ucfirst($type)], $this->_defaultPath . $path) . PHP_EOL;
		} else {
			throw new \Exception('Unsupported file type');
		}
	}

	/**
	 * Prepares multiple resources
	 * @param $type
	 * @param array $paths
	 * @return string
	 */
	private function _prepare($type, $paths = [])
	{
		$data = '';
		foreach ($paths as $path) {
			$data .= $this->load($type, $path);
		}
		
		return $data;
	}

	public function setNoticeObject($name)
	{
		$this->_noticeObject = $name;
	}

	public function addNotice($type, $text)
	{
		$notice = new $this->_noticeObject($type, $text);

		$this->_notices[] = serialize($notice);
		\Core\Session::set('notices', json_encode($this->_notices));
	}

	public function getNotices()
	{
		$notices = \Core\Session::get('notices');
		\Core\Session::remove('notices');

		return $this->renderNotices(json_decode($notices, true));
	}

	public function renderNotices($data)
	{
		$text = '';
		foreach ($data as $notice) {
			$text = unserialize($notice)->show();
		}

		return $text;
	}
}

