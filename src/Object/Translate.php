<?php

namespace Core\Object;

class Translate extends \Core\Object
{
	protected $_table = 'Translate';

	public function fields()
	{
		$fields = [
			'id' => [
				'type' => 'int',
				'default' => null,
				'null' => false,
			],
			'key' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],
			'value' => [
				'type' => 'text',
				'default' => '',
				'null' => false,
			],
			'comment' => [
				'type' => 'varchar',
				'default' => '',
				'null' => false,
			],

			'languageTable' => [
				'value' => [
					'type' => 'text',
					'default' => null,
					'null' => false,
				],
			],
		];

		return array_merge($fields, parent::fields());
	}
}
