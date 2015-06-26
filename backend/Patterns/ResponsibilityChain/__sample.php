<?php

/**
 *
 * CHAIN OF RESPONSIBILITY
 *
 * The Chain of Responsibility is a behavioral design pattern
 * that processes a request through a series of processor (handlers/receivers) objects.
 *
 * The request is sent from one handler object to another and processed by some or all of the handlers.
 * All the handlers are part of the chain.
 *
 */

require_once('../../../../../autoload.php');

class StepA extends \Core\Patterns\ResponsibilityChain\Handler {
	public function process($request) {
		return $request . ' __processedByStepA';
	}
}

class StepB extends \Core\Patterns\ResponsibilityChain\Handler {
	public function process($request) {
		return $request . ' __processedByStepB';
	}

	/**
	 * Overrides basic handle method with own behaviour of handling next parts of chain
	 * @param $request
	 * @return string
	 * @throws \Exception if something is going wrong
	 */
	public function handle($request)
	{
		if (strpos($request, '__processedByStepA') !== false) {
			return parent::handle($request);
		} else {
			throw new \Exception('Failed on step B');
		}
	}
}

class StepC extends \Core\Patterns\ResponsibilityChain\Handler
{
	private $_param;

	public function __construct($param = '')
	{
		$this->_param = $param;
	}

	public function process($request)
	{
		return $request . ' __processedByStepC' . $this->_param;
	}
}


//init the chain from step A
$chain = StepA::init();

$chain
	//set successor of step A
	->setSuccessor(new StepB())

	//set successor of step B
	->setSuccessor(new StepC('Configured'));


//run the chain
//it will return: DATA __processedByStepA __processedByStepB __processedByStepCConfigured

echo $chain->handle('DATA') . PHP_EOL;
