<?php

namespace Core;

use Core\Database\PDO;

class Api extends Controller
{
	protected $request;

	/**
	 * Assigns PDO connection to protected variable
	 * for using in API Controllers
	 */
	public function __construct()
	{
		$this->db = PDO::getInstance();
		parent::__construct();
	}

	/**
	 * Api run wrapper for response formatting
	 * and errors catching
	 * @param $method
	 * @param $args
	 * @return array
	 */
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
