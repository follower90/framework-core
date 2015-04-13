<?php

/**
 * @describe testSelectParams()
 * @it should add select configuration
 *
 * @describe testJoinParams()
 * @it should add joins configuration
 *
 * @describe testConditionsParams()
 * @it shoud add correct 'where' conditions
 *
 * @describe testSortingParams()
 * @it should set sorting
 *
 * @describe testGroupingParams()
 * @it should set groupBy params
 *
 * @describe testOffsetLimitParams()
 * @it should set sort and limit params
 *
 * @describe testQueryComposer()
 * @it should return correct sql query
 */


use Core\Database\QueryBuilder;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
	private $q;

	public function setUp()
	{
		$this->q = new QueryBuilder('Product');
	}

	/**
	 * @implements testSelectParams()
	 * @behaviour should add select configuration
	 */
	public function testSelectParams()
	{
		$this->q->select('id')
				->select('title', 'name')
				->select('product', 'name', 'table2');

		$this->assertEquals($this->q->debug('fields'), [
				['field' => 'id', 'alias' => '', 'table' => ''],
				['field' => 'title', 'alias' => 'name', 'table' => ''],
				['field' => 'product', 'alias' => 'name', 'table' => 'table2'],
			]
		);
	}

	/**
	 * @implements testJoinParams()
	 * @it should add joins configuration
	 */
	public function testJoinParams()
	{
		$this->q->setBaseAlias('pc')
				->join('left', 'product_catalog', 'pc', ['catalog', 'another.id'])
				->join('left', 'product_catalog', 'pc', ['catalog', 'another.id']);

		$this->assertEquals($this->q->debug('joins'), [
				['type' => 'left', 'table' => 'product_catalog', 'field' => 'catalog', 'external' => 'another.id', 'alias' => 'pc'],
				['type' => 'left', 'table' => 'product_catalog', 'field' => 'catalog', 'external' => 'another.id', 'alias' => 'pc'],
			]
		);
	}

	/**
	 * @implements testConditionsParams()
	 * @it shoud add correct 'where' conditions
	 */
	public function testConditionsParams()
	{
		$this->q->where('somevalue', [124, 125])
				->where('max(count)', 20, '<')
				->where('title', '%test', 'like')
				->where('test', null);

		$this->assertEquals($this->q->debug('where'), [
				['value' => 'tb.somevalue', 'args' => [124, 125], 'action' => '='],
				['value' => 'max(tb.count)', 'args' => 20, 'action' => '<'],
				['value' => 'tb.title', 'args' => '%test', 'action' => 'like'],
				['value' => 'tb.test', 'args' => 'null', 'action' => '='],
			]
		);
	}

	/**
	 * @implements testSortingParams()
	 * @it should set sorting
	 */
	public function testSortingParams()
	{
		$this->q->setBaseAlias('r')
				->orderBy('id', 'asc')
				->orderBy('count', 'desc');

		$this->assertEquals($this->q->debug('order'), [
				['field' => 'r.id', 'direction' => 'asc'],
				['field' => 'r.count', 'direction' => 'desc'],
			]
		);
	}

	/**
	 * @implements testGroupingParams()
	 * @it should set groupBy params
	 */
	public function testGroupingParams()
	{
		$this->q->groupBy('param1')
				->groupBy('tb2.param2');

		$this->assertEquals($this->q->debug('group'),[
				['field' => 'tb.param1'],
				['field' => 'tb2.param2'],
			]
		);
	}


	/**
	 * @implements testOffsetLimitParams()
	 * @it should set sort and limit params
	 */
	public function testOffsetLimitParams()
	{
		$this->q->offset(5)
				->limit(30)
				->limit(20);

		$this->assertEquals($this->q->debug('offset'), [5]);
		$this->assertEquals($this->q->debug('limit'), [20]);
	}

	/**
	 * @implements testQueryComposer()
	 * @it should return correct sql query
	 */
	public function testQueryComposer()
	{
		$this->q
				->select('id')
				->select('title', 'name')
				->join('left', 'product_catalog', 'pc', ['catalog', 'tb.id'])
				->where('somevalue', [124, 125])
				->where('max(count)', 20, '<')
				->orderBy('id', 'asc')
				->limit(20);

		$this->assertEquals(
			$this->q->composeSelectQuery(),
			'select tb.id, tb.title as name from Product tb left join product_catalog pc on pc.catalog = tb.id where tb.somevalue = in (124,125) and max(tb.count) < 20 order by tb.id asc limit 20'
		);
	}
}
