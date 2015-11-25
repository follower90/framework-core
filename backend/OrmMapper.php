<?php

namespace Core;

class OrmMapper
{
	private $_collection = [];
	private $_object = [];
	private $_fields = [];
	private $_filters = [];
	private $_offset;
	private $_sorting;
	private $_limit;

	private $_map;
	private $_allowedFields = [];

	/**
	 * Private constructor
	 * Sets class and gets object configs
	 * @param $class
	 */
	private function __construct($class)
	{
		$this->_object = new $class();
		$this->_object->getConfig();
		$this->_allowedFields = array_keys($this->_object->getConfigData('fields'));
	}

	/**
	 * Creates new OrmMapper
	 * @param $class
	 * @return \Core\OrmMapper
	 * @throws \Exception
	 */
	public static function create($class)
	{
		$className = Orm::detectClass($class);
		return new OrmMapper($className);
	}

	/**
	 * Returns object collection
	 * @return \Core\Collection
	 */
	public function getCollection()
	{
		return new Collection($this->_collection);
	}

	/**
	 * Sets fields for getting
	 * @todo fix for getting related fields
	 * @param $fields
	 * @return \Core\OrmMapper
	 */
	public function setFields($fields)
	{
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

	/**
	 * Set ordering
	 * @param $field
	 * @param string $sort
	 * @return \Core\OrmMapper
	 */
	public function setSorting($field, $sort = 'asc')
	{
		$this->_sorting = [$field, $sort];
		return $this;
	}

	/**
	 * Set filter conditions
	 * @param $keys
	 * @param $values
	 * @return \Core\OrmMapper
	 */
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

	/**
	 * Add single filter conditions
	 * @param $key
	 * @param $value
	 * @return \Core\OrmMapper
	 */
	public function addFilter($key, $value)
	{
		$this->_filters[$key] = $value;
		$this->_filters = array_unique($this->_filters);
		return $this;
	}

	/**
	 * Set offset
	 * @param $offset
	 * @return \Core\OrmMapper
	 */
	public function setOffset($offset)
	{
		$this->_offset = (int)$offset;
		return $this;
	}

	/**
	 * Set limit
	 * @param $limit
	 * @return \Core\OrmMapper
	 */
	public function setLimit($limit)
	{
		$this->_limit = (int)$limit;
		return $this;
	}

	/**
	 * Load mapper with set params
	 * @return \Core\Collection
	 */
	public function load()
	{
		$this->_object->getConfig();
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

		return $this->getCollection();
	}

	/**
	 * Returns simple array values map
	 * @return array
	 * @throws \Exception
	 */
	public function getDataMap()
	{
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

	/**
	 * Get related mapper by object relation
	 * @param $alias
	 * @return bool|OrmMapper
	 */
	public function getRelatedMapper($alias)
	{
		if (!in_array($alias, $this->_object->relations())) {
			return false;
		}

		$relation = $this->_object->relations()[$alias];
		$ids = [];

		$collection = $this->getCollection();

		foreach ($collection as $object) {
			$ids[] = $object->getValue($relation['field']);
		}

		$relatedMapper = OrmMapper::create($relation['class']);
		$relatedMapper
			->setFilter(['id'], [$ids])
			->load();

		return $relatedMapper;
	}
}

