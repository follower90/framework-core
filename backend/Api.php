<?php

namespace Core;

use Core\Database\PDO;

class Api extends Controller //todo really needed?
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

	/**
	 * Not authorized response
	 */
	public static function notAuthorized()
	{
		Router::sendHeaders(['Content-Type: application/json', Router::NOT_AUTHORIZED]);
		echo json_encode(['errors' => 'Not authorized']);
		exit;
	}

	public static function notFound()
	{
		Router::sendHeaders(['Content-Type: application/json', Router::NOT_FOUND_404]);
		echo json_encode([
			'status' => false,
			'error' => [
				'code' => 404,
				'message' => 'Endpoint was not found'
			]
		]);
		exit;
	}
}
