<?php
namespace Core\Controller;

use Core\Database\PDO;
use Core\View;
use Core\Orm;
use Core\Config;

class Controller
{
	protected $db;
	protected $view;
	protected $settings;

	function __construct()
	{
		$this->db = PDO::getInstance();
		$this->view = new View();
	}

	function params($key = false)
	{
		$uri = explode('/', $_SERVER['REQUEST_URI']);
		$params = [];

		for ($i = 1; $i < count($uri); ) {
			$params[$uri[$i]] = $uri[++$i];
			++$i;
		}

		if ($key) {
			return $params[$key];
		}

		return $params;
	}
}
