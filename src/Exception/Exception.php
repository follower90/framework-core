<?php

namespace Core\Exception;

class Api extends \Exception
{
	public function __construct(\Exception $e)
	{
		var_dump($e);
	}
}
