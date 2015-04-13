<?php

namespace Core\Database;

interface IDatabase
{
	public function insert($table, $params);
	public function update($table, $params, $conditions);
	public function delete($table, $conditions);
}