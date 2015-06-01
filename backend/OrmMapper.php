<?php

namespace Core;

class OrmMapper
{
	private $_collection = false;

	private $_object = [];
	private $_fields = [];
	private $_filters = [];
	private $_offset;
	private $_sorting;
	private $_limit;

	private $_map;
	private $_allowedFields = [];

	private function __construct($class)
	{
		$this->_object = new $class();
		$this->_object->getConfig();
		$this->_allowedFields = array_keys($this->_object->getConfigData('fields'));
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
			if (in_array($item, $allowedFields) || strpos($item, '.') > 0) {
				return true;
			}

			return false;
		});

		$this->_fields = array_unique(array_merge($this->_fields, $fields));
		return $this;
	}

	public function setSorting($field, $sort = 'asc')
	{
		$this->_sorting = [$field, $sort];
		return $this;
	}

	public function setFilter($keys, $values)
	{
		$num = 0;
		foreach ($keys as $key) {
			$this->_filters[$key] = $values[$num];
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
		$this->_object->getConfig();//shit
		$this->_collection = Orm::find(
			$this->_object->getConfigData('table'),
			array_keys($this->_filters),
			array_values($this->_filters),
			[
				'sort' => $this->_sorting,
				'limit' => $this->_limit,
				'offset' => $this->_offset
			]
		)->getCollection();

		return $this;
	}

	public function getDataMap()
	{
		if ($this->_collection === false) {
			throw new \Exception('Nothing to get. Load data map first');
		}

		$this->_map = [];

		foreach ($this->_collection as $object) {
			$item = [];

			foreach ($this->_fields as $field) {

				if (strpos($field, '.') > 0) {
					$relation = explode('.', $field)[0];
					$field = explode('.', $field)[1];

					$related = $object->getRelated($relation);
					$item[$relation][$field] = $related->getValue($field);
				} else {
					$item[$field] = $object->getValue($field);
				}
			}

			$this->_map[] = $item;
		}

		if ($this->_limit == 1) {
			return $this->_map[0];
		}

		return $this->_map;
	}

	public function getRelatedMapper($alias)
	{
		if (!in_array($alias, $this->_object->relations())) {
			return false;
		}

		$relation = $this->_object->relations()[$alias];
		$ids = [];

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

