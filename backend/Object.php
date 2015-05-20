<?php

namespace Core;

class Object
{
	protected $_table;
	protected $_relations;
	protected $_values;

	private $_hasChanges = false;

	public function __construct($values = [])
	{
		if (!empty($values)) {
			$this->setValues($values);
		}
	}

	public function fields()
	{
		$fields = [
			'id' => [
				'type' => 'int',
				'default' => null,
				'null' => false,
			]
		];

		return $fields;
	}

	public function relations()
	{
		return [];
	}

	public function save()
	{
		Orm::save($this);
	}

	public function table()
	{
		return $this->_table;
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
		$fields = $this->fields();
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

	public function isActive()
	{
		return (bool)$this->getValue('active');
	}

	public function isModified()
	{
		return $this->_hasChanges;
	}
}
