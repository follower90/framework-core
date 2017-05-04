<?php

namespace Core\Socket;

class Server
{
	private $_ip;
	private $_port;

	public function __construct($ip, $port)
	{
		$this->_ip = $ip;
		$this->_port = $port;
	}

	/**
	 * Run socket server
	 * @todo rewrite this piece of shit
	 * @throws \Exception if could not start socket stream
	 */
	public function run()
	{
		$socket = stream_socket_server('tcp://' . $this->_ip . ':' . $this->_port, $errorCode, $errorString);
		if (!$socket) {
			throw new \Core\Exception\Exception("$errorString ($errorCode)<br />");
		} else {
			while ($conn = stream_socket_accept($socket)) {
				fwrite($conn, 'The local time is ' . date('n/j/Y g:i a') . "\n");
				fclose($conn);
			}

			fclose($socket);
		}
	}
}
