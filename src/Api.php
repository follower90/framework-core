<?php

namespace Core;

class Api
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

		return self::output($response);
	}

	public function output($data)
	{
		$debugMode = Cookie::get('cmsDebug') || $this->request['cmsDebug'] == 'on';
		if (!$debugMode) {
			header('Content-Type: application/json');
		}
		
		echo json_encode($data);
	}

	public function _request()
	{
		return array_merge($_POST, $_GET, $_REQUEST);
	}
}
