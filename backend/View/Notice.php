<?php

namespace Core;

class Notice
{
	protected $_type;
	protected $_text;

	public function __construct($type, $text)
	{
		$this->_type = $type;
		$this->_text = $text;
	}

	public static function create($type, $text)
	{
		return new static($type, $text);
	}

	public function show()
	{
		return '<span class="notice ' . $this->_type . '">' . $this->_text . '</span>';
	}
}
