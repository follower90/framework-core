<?php

namespace Core\Patterns\ResponsibilityChain;


abstract class Handler implements IHandler
{
	protected $_successor = null;

	public function setSuccessor(IHandler $handler)
	{
		$this->_successor = $handler;
	}

	public function handle($request)
	{
		$response = $this->process($request);
		if ($this->_successor) {
			$response = $this->_successor->handle($response);
		}

		return $response;
	}

	public function process($request)
	{
		return $request;
	}
}
