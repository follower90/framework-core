<?php

namespace Core\Exception;

class Exception extends \Exception
{
	public function __construct($message, $code = 0, \Exception $prev = null)
	{
		parent::__construct($message, $code, $prev);
	}
}
