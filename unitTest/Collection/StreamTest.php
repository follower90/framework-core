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
		$this->obj1 = new Translate();
		$this->obj1->setValues([
			'key' => 'test1',
			'value' => 'value1',
			'comment' => 'test object 1',
		]);

		$this->obj2 = new Translate();
		$this->obj2->setValues([
			'key' => 'test2',
			'value' => 'value2',
			'comment' => 'test object 2',
		]);

		$this->obj3 = new Translate();
		$this->obj3->setValues([
			'key' => 'test3',
			'value' => 'value3',
			'comment' => 'test object 3',
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
		$filter = function(&$obj) { return in_array($obj->getValue('value'), ['value1', 'value3']); };

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
		$filter1 = function(&$obj) { return isset($obj->getValues()['key']); };
		$filter2 = function(&$obj) { return $obj->getValue('value') == 'value2'; };

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
		$filter = function(&$obj) { return $obj->getValue('value') == 1000; };

		$stream = $this->collection
			->stream()
			->filter($filter);

		$objects = $stream->find();

		$this->assertEquals($objects, []);
		$this->assertEquals($stream->size(), 0);
		$this->assertEquals($stream->isEmpty(), true);
	}
}
