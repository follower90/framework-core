<?php

namespace Core\Patterns\ResponsibilityChain;


interface IHandler
{
	public function setSuccessor(IHandler $handler);
	public function handle($request);
	public function process($request);
}
