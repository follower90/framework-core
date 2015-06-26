<?php

class StepA extends \Core\Patterns\ResponsibilityChain\Handler {
	public function process($request) {
		return $request . '__processedByStepA';
	}
}

class StepB extends \Core\Patterns\ResponsibilityChain\Handler {
	public function process($request) {
		return $request . '__processedByStepB';
	}
}

$a = new StepA();
$b = new StepB();

$a->setSuccessor($b);
$a->handle('DATA');