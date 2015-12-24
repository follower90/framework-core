<?php

namespace Core\Exception;

use Core\Debug;

class Exception extends \Exception
{
	public function __construct($message, $code = 0, \Exception $prev = null)
	{
		$debugger = Debug::getInstance();
		$debugger->logFrameworkError($message);

		parent::__construct($message, $code, $prev);
	}
}
