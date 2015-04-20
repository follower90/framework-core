<?php

/**
 * @describe testReturnStream()
 * @it should return collection stream
 *
 * @describe testReturnSingleFromStream()
 * @it should return first object from collection stream
 *
 * @describe testReturnFilteredCollection()
 * @it should return single-filtered collection stream
 *
 * @describe testReturnMultiFilteredCollection()
 * @it should return multi-filtered collection stream
 */

use Core\Object\Translate;
use Core\Collection;

class StreamTest extends \PHPUnit_Framework_TestCase
{
	private $collection;

	private $obj1;
	private $obj2;
	private $obj3;

	public function setUp()
	{
		$this->$obj1 = new Translate();
		$this->$obj1->setValues([
			'key' => 'test',
			'value' => 'value',
			'comment' => 'test object',
		]);

		$this->$obj2 = new Translate();
		$this->$obj2->setValues([
			'key' => 'test',
			'value' => 'value',
			'comment' => 'test object',
		]);

		$this->$obj3 = new Translate();
		$this->$obj3->setValues([
			'key' => 'test',
			'value' => 'value',
			'comment' => 'test object',
		]);

		$this->collection = new Collection([$this->$obj1, $this->$obj2, $this->$obj3]);
	}

	/**
	 * @implements testReturnStream()
	 * @it should return collection stream
	 */
	public function testReturnStream()
	{
		$objects = $this->collection
			->stream()
			->find();

		$this->assertEquals($objects, [$this->obj1, $this->obj2, $this->obj3]);
	}

	/**
	 * @implements testReturnSingleFromStream()
	 * @it should return first object from collection stream
	 */
	public function testReturnSingleFromStream()
	{
		$objects = $this->collection
			->stream()
			->findFirst();

		$this->assertEquals($objects, $this->obj1);
	}

	/**
	 * @implements testReturnFilteredCollection()
	 * @it should return single-filtered collection stream
	 */
	public function testReturnFilteredCollection()
	{
		$filter = function(&$obj) { return isset($obj->getValues()['key']); };

		$objects = $this->collection
			->stream()
			->filter($filter)
			->find();

		$this->assertEquals($objects, [$this->obj1, $this->obj3]);
	}

	/**
	 * @implements testReturnMultiFilteredCollection()
	 * @it should return multi-filtered collection stream
	 */
	public function testReturnMultiFilteredCollection()
	{
		$filter1 = function(&$obj) { return isset($obj->getValues()['key']); };
		$filter2 = function(&$obj) { return $obj->getValue('value') == 5; };

		$objects = $this->collection
			->stream()
			->filter($filter1)
			->filter($filter2)
			->find();

		$this->assertEquals($objects, [$this->obj1, $this->obj3]);
	}

}
