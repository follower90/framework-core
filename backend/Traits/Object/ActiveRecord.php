<?php

namespace Core;

trait ActiveRecord
{
	/**
	 * Returns orm mapper for object
	 * @return OrmMapper
	 */
	public static function all()
	{
		return OrmMapper::create(static::getClassName());
	}

	/**
	 * Returns new user object
	 * @return Object
	 */
	public static function create()
	{
		return new static();
	}

	/**
	 * Syntax sugar, just saves object with Orm
	 * @throws \Exception
	 */
	public function save()
	{
		Orm::save($this);
	}

	/**
	 * Syntax sugar, just deletes object with Orm
	 * @throws \Exception
	 */
	public function delete()
	{
		Orm::delete($this);
	}


	/**
	 * ActiveRecord-like syntax sugar
	 * @param int $id
	 * @return bool|\Core\Object
	 */
	public static function find($id)
	{
		return Orm::load(self::getClassName(), $id);
	}

	/**
	 * ActiveRecord-like syntax sugar
	 * @param $params
	 * @return bool|Collection
	 */
	public static function findBy($params)
	{
		return self::where($params)->getFirst();
	}


	/**
	 * ActiveRecord-like syntax sugar
	 * @param $params
	 * @return bool|Collection
	 */
	public static function where($params)
	{
		$filters = array_keys($params);
		$values = array_values($params);

		return Orm::find(self::getClassName(), $filters, $values);
	}

	/**
	 * Syntax sugar method
	 * Sets arguments using magic method
	 * for use setValue method like direct property
	 * @param attr
	 * @param value
	 */
	public function __set($attr, $value)
	{
		$this->setValue($attr, $value);
	}

	/**
	 * Syntax sugar method
	 * Returns value using magic method
	 * for use getValue method like direct property
	 * @param attr
	 * @return OrmMapper
	 */
	public function __get($attr)
	{
		return $this->getValue($attr);
	}
}
