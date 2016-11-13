<?php

namespace Core\Object;

class File extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('File');
			self::$_config->setFields([
				'src' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'info' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
