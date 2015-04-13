<?php

namespace Core;

use Core\Database\MySQL;

class Object
{
	protected $_table;
	protected $_relations;
	protected $_values;

	private $_hasChanges = false;

	public function __construct()
	{

	}

	public function save()
	{
		if (!$this->_hasChanges) {
			return false;
		}

		$data = [];
		$langData = [];

		foreach ($this->_values as $field => $value) {
			if ($field != 'languageTable') {
				$data[$field] = $value;
			}
		}

		if (isset($this->_values['languageTable'])) {
			foreach ($this->_values['languageTable'] as $field => $value) {
				$langData[] = ['field' => $field, 'value'=> $value];
			}
		}

		try {
			if ($id = $this->getId()) {
				MySQL::update($this->_table, $data, ['id' => $id]);
			} else {
				$id = MySQL::insert($this->_table, $data);
			}

		} catch (\Exception $e) {
			throw new \Exception('Error inserting data to ' . $this->_table, 1);
		}

		if ($langData) {
			$language = Config::get('site.language');

			foreach ($langData as $values) {
				if ($id = $this->getId()) {
					MySQL::update($this->_table . '_Lang', $values, [strtolower($this->_table) . '_id' => $id, 'lang' => $language, 'field' => $values['field']]);
				} else {
					MySQL::insert($this->_table . '_Lang', array_merge([strtolower($this->_table) . '_id' => $id, 'lang' =>$language], $values));
				}
			}
		}

		$this->setValue('id', $id);
	}

	public function delete()
	{
		Orm::delete($this);
	}

	public function config()
	{
		$fields = [];
		return $fields;
	}

	public function table()
	{
		return $this->_table;
	}

	public static function create($class)
	{
		$class = '\\src\\Core\\Object\\' . $class;
		return new $class();
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
		$fields = $this->config();
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
	}

	public function getId()
	{
		return $this->getValue('id');
	}

	public function isActive()
	{
		return (bool)$this->getValue('active');
	}
}
