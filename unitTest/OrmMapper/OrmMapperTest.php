<?php

/**
 * @describe testApplyFields()
 * @it should apply fields according to used object
 *
 */

use Core\OrmMapper;

class OrmMapperTest extends \PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		\Core\Config::setProject('Accounting');
	}

	/**
	 * @implements testApplyFields()
	 * @it should apply fields according to used object
	 */
	public function testApplyFields()
	{
		$mapper = OrmMapper::create('Category');
		$mapper->setFields(['test', 'name', 'amount']);
		$mapper->setFilter(['test', 'name', 'amount'], [1,2,3]);
		var_dump($mapper);
	}

}
