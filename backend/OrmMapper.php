<?php

namespace Core;

class OrmMapper
{
	private $_collection = [];

	private $_object = [];
	private $_fields = [];
	private $_filters = [];
	private $_offset;
	private $_limit;

	private $_allowedFields = [];

	private function __construct($class)
	{
		$this->_object = new $class();
		$this->_allowedFields = array_keys($this->_object->fields());
	}

	public static function create($class)
	{
		$className = Orm::detectClass($class);
		return new OrmMapper($className);
	}

	public function getCollection()
	{
		return $this->_collection;
	}

	public function setFields($fields)
	{
		//todo - fix for relations

		$allowedFields = $this->_allowedFields;
		$fields = array_filter($fields, function ($item) use ($allowedFields) {
			if (in_array($item, $allowedFields)) {
				return true;
			}

			return false;
		});

		$this->_fields = array_unique(array_merge($this->_fields, $fields));
		return $this;
	}

	public function setFilter($keys, $values)
	{
		//todo - fix for relations

		$allowedFilters = $this->_allowedFields;
		$num = 0;

		foreach ($keys as $key => $filter) {
			if (in_array($filter, $allowedFilters) && !empty($values[$num])) {
				$this->_filters[] = [$filter => $values[$num]];
			}

			$num++;
		}

		$this->_filters = array_unique($this->_filters);
		return $this;
	}

	public function setOffset($offset)
	{
		$this->_offset = (int)$offset;
		return $this;
	}

	public function setLimit($limit)
	{
		$this->_limit = (int)$limit;
		return $this;
	}

	public function load()
	{
		//todo - apply fields, filters, limit, offset, etc. and fill collection using Orm
	}

	public function getRelatedMapper($alias)
	{
		if (!in_array($alias, $this->_object->relations())) {
			return false;
		}

		$relation = $this->_object->relations()[$alias];
		$ids = [];

		//todo - fix for multiple relations

		foreach ($this->getCollection() as $object) {
			$ids[] = $object->getValue($relation['field']);
		}

		$relatedMapper = OrmMapper::create($relation['class']);
		$relatedMapper
			->setFilter(['id'], [$ids])
			->load();

		return $relatedMapper;
	}
}

