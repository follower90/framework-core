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

	public function render($fragment = false)
	{
		if (!$fragment) {
			$fragment = $this->_template;
		}

		$dom = new \DOMDocument();
		$dom->loadHTML($fragment);

		$xpath = new \DOMXPath($dom);
		$foreach = $xpath->query('//foreach');

		if ($node = $foreach->item(0)) {
			return $this->render(
				str_replace($this->getInnerHtml($node), $this->renderCycle($node), $fragment)
			);
		}

		return $this->renderVars($fragment, $this->_vars);
	}

	private function renderCycle(\DOMElement $foreach)
	{
		$key = $foreach->getAttribute('from');
		$replacement = $foreach->getAttribute('item');
		$fragment = $this->getInnerHtml($foreach);

		$rendered = '';
		$data = array_merge($this->_vars, $this->_internal);

		foreach ($data[$key] as $item) {
			if (is_array($item)) {
				$this->_internal[$replacement] = $item;
				$item = implode(',', $item);
			}

			$node = $this->renderVars($fragment, [$replacement => $item]);
			$rendered .= $this->render($node);
			$this->_internal = [];
		}

		return $rendered;
	}

	private function renderVars($fragment, $vars = [])
	{
		$this->removeNestedCycles($fragment);
		foreach ($vars as $key => $value) {
			$fragment = str_replace("{{{$key}}}", $value, $fragment);
		}

		return $fragment;
	}

	private function removeNestedCycles($fragment)
	{
		$dom = new \DOMDocument();
		$dom->loadHTML($fragment);

		$document = $dom->documentElement;

		if ($tag = $document->getElementsByTagName('foreach')->item(0)) {
			$tag->parentNode->removeChild($tag);
			return $this->removeNestedCycles($dom->saveHTML());
		}

		return $fragment;
	}

	private function getInnerHtml($node)
	{
		$innerHTML = '';
		$children = $node->childNodes;

		foreach ($children as $child) {
			$innerHTML .= $child->ownerDocument->saveXML($child);
		}

		return $innerHTML;
	}
}
