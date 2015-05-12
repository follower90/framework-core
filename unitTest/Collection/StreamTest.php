<?php

/**
 * @describe testReturnStream()
 * @it should return collection stream
 *
 * @describe testReturnStreamArray()
 * @it should return collection stream array
 *
 * @describe testReturnSingleFromStream()
 * @it should return first object from collection stream
 *
 * @describe testReturnFilteredCollection()
 * @it should return single-filtered collection stream
 *
 * @describe testReturnMultiFilteredCollection()
 * @it should return multi-filtered collection stream
 *
 * @describe testReturnEmptyCollection()
 * @it should return empty collection if filter doesn't match
 */

use Core\Object\User;
use Core\Collection;

class StreamTest extends \PHPUnit_Framework_TestCase
{
	private $collection;

	private $obj1;
	private $obj2;
	private $obj3;

	public function setUp()
	{
		$this->obj1 = new User();
		$this->obj1->setValues([
			'name' => 'test1',
			'password' => 'value1',
		]);

		$this->obj2 = new User();
		$this->obj2->setValues([
			'name' => 'test2',
			'password' => 'value2',
		]);

		$this->obj3 = new User();
		$this->obj3->setValues([
			'name' => 'test3',
			'password' => 'value3',
		]);

		$this->collection = new Collection([$this->obj1, $this->obj2, $this->obj3]);
	}

	/**
	 * @implements testReturnStream()
	 * @it should return collection stream
	 */
	public function testReturnStream()
	{
		$stream = $this->collection->stream();
		$this->assertEquals(get_class($stream), 'Core\Collection\Stream');
	}

	/**
	 * @implements testReturnStreamArray()
	 * @it should return collection stream array
	 */
	public function testReturnStreamArray()
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
		$filter = function(&$obj) { return in_array($obj->getValue('password'), ['value1', 'value3']); };

		$stream = $this->collection
			->stream()
			->filter($filter);

		$objects = $stream->find();

		$this->assertEquals($objects, [$this->obj1, $this->obj3]);
		$this->assertEquals($stream->isEmpty(), false);
	}

	/**
	 * @implements testReturnMultiFilteredCollection()
	 * @it should return multi-filtered collection stream
	 */
	public function testReturnMultiFilteredCollection()
	{
		$filter1 = function(&$obj) { return isset($obj->getValues()['name']); };
		$filter2 = function(&$obj) { return $obj->getValue('password') == 'value2'; };

		$stream = $this->collection
			->stream()
			->filter($filter1)
			->filter($filter2);

		$objects = $stream->find();

		$this->assertEquals($objects, [$this->obj2]);
		$this->assertEquals($stream->size(), 1);
	}

	/*
	 * @implements testReturnEmptyCollection()
	 * @it should return empty collection if filter doesn't match
	 */
	public function testReturnEmptyCollection()
	{
		$filter = function(&$obj) { return $obj->getValue('password') == 1000; };

		$stream = $this->collection
			->stream()
			->filter($filter);

		$objects = $stream->find();

		$this->assertEquals($objects, []);
		$this->assertEquals($stream->size(), 0);
		$this->assertEquals($stream->isEmpty(), true);
	}
}
