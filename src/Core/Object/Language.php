<?php

namespace Core\Object;

class Language extends \Core\Object
{
	protected $_table = 'Language';
	public function config()
	{
		$fields = [
			'id' => [
				'type' => 'int',
				'default' => null,
				'null' => false,
			],
			'language' => [
				'type' => 'char',
				'length' => 2,
				'default' => '',
				'null' => false,
			],
			'sort' => [
				'type' => 'int',
				'default' => null,
				'null' => false,
			],
			'default' => [
				'type' => 'tinyint',
				'default' => null,
				'null' => false,
			],
		];

		return array_merge($fields, parent::config());
	}
}
