<?php

namespace Core\Object;

class User_Session extends \Core\Object
{
	protected $_table = 'User_Session';

	public function fields()
	{
		$fields = [
			'userId' => [
				'type' => 'id',
				'default' => '',
				'null' => false,
			],
			'entity' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],
			'hash' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],
		];

		return array_merge($fields, parent::fields());
	}
}

