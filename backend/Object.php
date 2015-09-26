<?php

namespace Core;

abstract class Object
{
	protected $_table;
	protected $_class;

	protected $_values;

	protected $_hasChanges = false;

	protected static $_config;
	protected static $_events = [];
	protected static $_objectRelations = [];

	/**
	 * Object constructor
	 * Sets class name, can set values at once
	 * @param array $values
	 */
	public function __construct($values = [])
	{
		$this->_class = $this->getClassName();

		if (!empty($values)) {
			$this->setValues($values);
		}
	}

	/**
	 * Syntax sugar method
	 * Just returns orm mapper for object
	 * @return OrmMapper
	 */
	public static function all()
	{
		return OrmMapper::create(static::getClassName());
	}

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = new ObjectConfig();
			self::$_config->setFields([
				'id' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				]
			]);
		}
		return self::$_config;
	}

	/**
	 * Returns just object name, without namespaces
	 * @return mixed
	 */
	public static function getClassName()
	{
		$fullClassName = get_called_class();
		$chunks = explode('\\', $fullClassName);

		return $chunks[sizeof($chunks) - 1];
	}

	/**
	 * Returns settings array from \Core\ObjectConfig
	 * @param $alias
	 * @return array
	 */
	public function getConfigData($alias)
	{
		return $this->getConfig()->getData($alias);
	}

	/**
	 * Returns object relations
	 * @return array
	 */
	public function relations()
	{
		return static::$_objectRelations;
	}

	/**
	 * Object validation method
	 * should be overridden in the object
	 * @return array
	 */
	public function validate()
	{
		return true;
	}

	/**
	 * Trigger callback for event
	 * if it was registered
	 * @param string $alias
	 */
	public function trigger($alias)
	{
		if (is_callable(self::$_events[$alias])) {
			self::$_events[$alias]();
		}
	}

	/**
	 * Register event callback
	 * @param string $alias
	 * @param \Closure $callback
	 */
	public function registerEvent($alias, \Closure $callback)
	{
		self::$_events[$alias] = $callback;
	}

	/**
	 * Syntax sugar, just saves object with Orm
	 * @throws \Exception
	 */
	public function save()
	{
		Orm::save($this);
	}

	public function getRelated($alias)
	{
		$relations = $this->relations();

		if (isset($relations[$alias])) {
			$relation = $relations[$alias];

			if (!isset($relation['multiple']) || $relation['multiple'] == false) {
				return Orm::load($relation['class'], $this->getValue($relation['field']));
			}
		}

		return false;
	}

	/**
	 * Set multiple values
	 * @param $data
	 */
	public function setValues($data)
	{
		$allowedFields = $this->_checkFields();
		$allowedLanguageFields = $this->_checkLanguageFields();

		foreach ($data as $field => $value) {

			if (in_array($field, $allowedFields)) {
				$this->setValue($field, $value);
			}

			if (in_array($field, $allowedLanguageFields)) {
				$this->setValue($field, $value);
			}
		}
	}

	/**
	 * Sets object value
	 * @param string $field field name
	 * @param $value int value
	 */
	public function setValue($field, $value)
	{
		$allowedFields = $this->_checkFields();
		$allowedLanguageFields = $this->_checkLanguageFields();

		if (in_array($field, $allowedFields)) {
			$this->_values[$field] = $value;
			$this->_hasChanges = true;
		}

		if (in_array($field, $allowedLanguageFields)) {
			$this->_values['languageTable'][$field] = $value;
			$this->_hasChanges = true;
		}
	}

	/**
	 * Returns existing fields
	 * @return array
	 */
	private function _checkFields()
	{
		$allowedFields = [];
		$fields = $this->getConfigData('fields');
		foreach ($fields as $field => $properties) {
			$allowedFields[] = $field;
		}

		if (isset($fields['languageTable'])) {
			foreach ($fields['languageTable'] as $field => $properties) {
				$allowedFields[] = $field;
			}
		}

		return $allowedFields;
	}

	private function _checkLanguageFields()
	{
		$fields = $this->getConfigData('fields');
		return isset($fields['languageTable']) ? array_keys($fields['languageTable']) : [];
	}

	/**
	 * Returns all object values
	 * @return mixed
	 */
	public function getValues()
	{
		$result = $this->_values;
		$languageData = [];

		if (isset($this->_values['languageTable'])) {
			$languageData = $this->_values['languageTable'];
		}

		unset($result['languageTable']);
		$result = array_merge($result, $languageData);

		return $result;
	}

	/**
	 * Returns object value if exists
	 *
	 * @param string $field field name
	 * @return bool|string field value
	 */
	public function getValue($field)
	{
		$allowedFields = $this->_checkFields();
		if (in_array($field, $allowedFields)) {
			return isset($this->_values[$field]) ? $this->_values[$field] : $this->_values['languageTable'][$field];
		}

		return false;
	}

	/**
	 * Returns object id
	 * @return bool
	 */
	public function getId()
	{
		return $this->getValue('id');
	}

	/**
	 * Returns true, if object has been modified
	 * @return bool
	 */
	public function isModified()
	{
		return $this->_hasChanges;
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
	 * ActiveRecord-like syntax sugar
	 * @param int $id
	 * @return bool|Collection
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
	 * Adds object relation
	 *
	 * @param string $alias relation alias
	 * @param array $relation relation config
	 */
	public static function addRelation($alias, $relation)
	{
		static::$_objectRelations[$alias] = $relation;
	}
}
