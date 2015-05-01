<?php

namespace Core\Exception;

class Exception extends \Exception
{
	public function __construct(\Exception $e)
	{
		//TODO
		var_dump($e);
	}
}
