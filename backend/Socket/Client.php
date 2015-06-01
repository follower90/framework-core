<?php

namespace Core\Socket;

class Client
{
	private $_ip;
	private $_port;

	public function __construct($ip, $port)
	{
		$this->_ip = $ip;
		$this->_port = $port;
	}
}
