<?php

namespace Core;

abstract class Object
{
	protected $_table;
	protected $_class;

	protected $_relations;
	protected $_values;

	protected $_hasChanges = false;

	protected static $_config;
	protected static $_objectRelations = [];

	public function __construct($values = [])
	{
		$this->_class = $this->getClassName();

		if (!empty($values)) {
			$this->setValues($values);
		}
	}

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

	public static function getClassName()
	{
		$fullClassName = get_called_class();
		$chunks = explode('\\', $fullClassName);

		return $chunks[sizeof($chunks) - 1];
	}

	public function getConfigData($alias)
	{
		return $this->getConfig()->getData($alias);
	}

	public function relations()
	{
		return static::$_objectRelations;
	}

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

	public function set($data = [])
	{
		$this->_values = $data;
	}

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

	public function setValue($field, $value)
	{
		$allowedFields = $this->_checkFields();
		if (in_array($field, $allowedFields)) {
			$this->_values[$field] = $value;
			$this->_hasChanges = true;
		}
	}

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

	public function getValues()
	{
		return $this->_values;
	}

	public function getValue($field)
	{
		$allowedFields = $this->_checkFields();
		if (in_array($field, $allowedFields)) {
			return isset($this->_values[$field]) ? $this->_values[$field] : $this->_values['languageTable'][$field];
		}

		return false;
	}

	public function getId()
	{
		return $this->getValue('id');
	}

	public function isModified()
	{
		return $this->_hasChanges;
	}

	public static function addRelation($alias, $relation)
	{
		static::$_objectRelations[$alias] = $relation;
	}
}
