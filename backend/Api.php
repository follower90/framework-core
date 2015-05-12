<?php

namespace Core;

class Api extends Controller
{
	protected $request;

	public function __construct()
	{
		$this->request = $this->_request();
	}

	public static function run($section, $method, $params)
	{
		try {
			$response = self::_request($section, $method, $params);
		} catch (\Exception $e) {

			$response = [
				'status' => false,
				'response' => $e->getMessage(),
			];
		}

		return $response;
	}

	public function _request()
	{
		return array_merge($_POST, $_GET);
	}
}
