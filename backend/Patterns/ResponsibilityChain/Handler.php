<?php

namespace Core\Patterns\ResponsibilityChain;


abstract class Handler implements IHandler
{
	/**
	 * next handler
	 * @var Handler
	 */
	protected $_successor = null;

	public static function init()
	{
		return new static();
	}

	/**
	 * Setting up next successor handler
	 * @param IHandler $handler
	 * @return IHandler this
	 */
	public function setSuccessor(IHandler $handler)
	{
		if ($this->_successor === null) {
			$this->_successor = $handler;
		} else {
			$this->_successor->setSuccessor($handler);
		}

		return $this;
	}

	/**
	 * Handles this handler
	 * and next handler if exists
	 * @param $request
	 * @return mixed
	 */
	public function handle($request)
	{
		$response = $this->process($request);
		if ($this->_successor) {
			$response = $this->_successor->handle($response);
		}

		return $response;
	}

	/**
	 * Processor function
	 * @param $request
	 * @return mixed
	 */
	public function process($request)
	{
		return $request;
	}
}
