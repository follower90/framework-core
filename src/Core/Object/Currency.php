<?php

namespace Core\Object;

class Currency extends \Core\Object
{
	protected $_table = 'Currency';
	public function config()
	{
		$fields = [
			'id' => [
				'type' => 'int',
				'default' => null,
				'null' => false,
			],
			'name' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],
		];

		return array_merge($fields, parent::config());
	}
}