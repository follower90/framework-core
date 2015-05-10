<?php

namespace Core\Object;

class User extends \Core\Object
{
	public function fields()
	{
		$fields = [
			'login' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],
			'password' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],
		];

		return array_merge($fields, parent::fields());
	}
}

