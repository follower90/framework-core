<?php

namespace Core;

abstract class Object
{
	protected $_table;
	protected $_class;

	protected $_values;

	protected $_hasChanges = false;

	protected static $_config;
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
	 * Syntax sugar, saves object with Orm
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

		foreach ($data as $field => $value) {
			if (in_array($field, $allowedFields)) {
				$this->setValue($field, $value);
			} else if ($field == 'languageTable') {
				$this->setValues($field);
			}
		}
	}

	/**
	 * Sets object value
	 *
	 * @param string $field field name
	 * @param $value field value
	 */
	public function setValue($field, $value)
	{
		$allowedFields = $this->_checkFields();
		if (in_array($field, $allowedFields)) {
			$this->_values[$field] = $value;
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

	/**
	 * Returns all object values
	 * @return mixed
	 */
	public function getValues()
	{
		return $this->_values;
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
