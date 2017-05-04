<?php

namespace Core\Database;

class Migration
{
	protected $_db;

	public function __construct()
	{
		$this->_db = PDO::getInstance();
	}

	/**
	 * Message about what migration does
	 * @return string
	 */
	public function describe() {}

	/**
	 * Db query to launch
	 * or another migration actions
	 */
	public function migrate() {}
}
