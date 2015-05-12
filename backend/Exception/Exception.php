<?php

namespace Core\Exception;

class Exception extends \Exception
{
	public function __construct(\Exception $e)
	{
		echo json_encode([$e->getCode(), $e->getMessage()]);
	}
}
