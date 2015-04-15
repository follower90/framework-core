<?php

namespace Core;

class Template
{
	private $_template = '';
	private $_vars = [];
	private $_internal = [];

	public function __construct($tpl, $vars = [])
	{
		$this->_template = $tpl;
		$this->_vars = $vars;
	}

	public function render()
	{
		return $this->findcycle($this->_template);
	}

	private function findCycle($fragment)
	{
		preg_match('/\{{2}each(.*)\s{1,2}as\s{1,2}(.*)\}{2}([\w\W]*)\{{2}\/each\}{2}$/m', $fragment, $matches);

		if (!empty($matches)) {
			$fragment = str_replace($matches[0], $this->renderCycle($matches), $fragment);
			return $this->findCycle($fragment);
		} else {
			return $this->renderVars($fragment, $this->_vars);
		}
	}

	private function renderCycle($match)
	{
		$key = trim($match[1]);
		$replacement = trim($match[2]);
		$fragment = $match[3];

		$rendered = '';

		$data = array_merge($this->_vars, $this->_internal);

		foreach ($data[$key] as $item) {
			if (is_array($item)) {
				$this->_internal[$replacement] = $item;
			}

			$node = $this->renderVars($fragment, [$replacement => $item]);
			$rendered .= $this->findCycle($node);
			$this->_internal = [];
		}

		return $rendered;
	}

	private function renderVars($fragment, $vars)
	{
		foreach ($vars as $key => $value) {
			$fragment = str_replace("{{{$key}}}", $value, $fragment);
		}

		return $fragment;
	}
}
