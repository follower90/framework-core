<?php

namespace Core;

use Core\Database\PDO;

class Authorize
{
	private $_db;
	private $_authorized;

	public function __construct()
	{
		$this->_db = PDO::getInstance();
		$this->_authorized = false;
	}

	public function login()
	{

	}

	public function logout()
	{

	}

	public function isAuthorized()
	{
		return $this->_authorized;
	}
}
