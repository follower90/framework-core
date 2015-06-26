<?php

namespace Core\Patterns\ResponsibilityChain;

interface IHandler
{
	public static function init();
	public function setSuccessor(IHandler $handler);
	public function handle($request);
	public function process($request);
}
