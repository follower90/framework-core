<?php

namespace Core\Object;

class Config extends \Core\Object
{
	protected $_table = 'Config';
	public function fields()
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
			'value' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],
			'type' => [
				'type' => 'int',
				'default' => null,
				'null' => false,
			],
			'comment' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],
		];

		return array_merge($fields, parent::fields());
	}
}