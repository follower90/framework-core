<?php

namespace Core;

class Api extends Controller
{
	protected $request;

	public function run($method, $args)
	{
		try {
			$data = call_user_func([$this, $method], $args);
			$response = [
				'status' => true,
				'response' => $data
			];

		} catch (\Exception $e) {
			$response = [
				'status' => false,
				'error' => [
					'code' => $e->getCode(),
					'message' => $e->getMessage(),
				]
			];
		}

		return $response;
	}
}
