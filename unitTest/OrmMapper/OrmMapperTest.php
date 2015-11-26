<?php

/**
 * @describe testCreateMapper()
 * @it should not create mapper for not existing object
 *
 * @describe testApplyFields()
 * @it should apply fields according to used object
 *
 * @describe testGetCollection()
 * @it should return result collection
 *
 * @describe testSetSorting()
 * @it should apply ordering filter
 *
 * @describe testAddFilter()
 * @it should apply field condition filter
 *
 * @describe testSetFilter()
 * @it should apply filters for multiple fields
 *
 * @describe testSetOffset()
 * @it should apply offset for query
 *
 * @describe testSetLimit()
 * @it should apply limit for query
 *
 * @describe testLoad()
 * @it should do Db request according to filters
 *
 * @describe testGetDataMap()
 * @it should return simple associative array with query result
 *
 * @describe testGetRelatedMapper()
 * @it should load related mapper with data related for current collection
 */

use Core\OrmMapper;

class OrmMapperTest extends \PHPUnit_Framework_TestCase
{
	/**
 	* @implements testCreateMapper()
 	* @it should create mapper for existing object
 	* @expectedException \Core\Exception\System\OrmException
	*/
	public function testCreateMapper()
	{
		$mapper = OrmMapper::create('NotExistingObject');
	}

	/**
	 * @implements testApplyFields()
	 * @it should apply fields according to used object
	 */
	public function testApplyFields()
	{
		$mapper = OrmMapper::create('User');
		$mapper->setFields(['login', 'password', 'not_exists']);
		$this->assertEquals($mapper->viewConfig('fields'), ['login', 'password']);
	}
}
