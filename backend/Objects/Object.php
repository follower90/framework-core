<?php

namespace Core;

use Core\Database\PDO;

abstract class Object
{
	use Traits\Object\Hooks;
	use Traits\Object\ActiveRecord;

	protected $_table;
	protected $_values;
	protected $_errors;
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
		if (!empty($values)) {
			$this->setValues($values);
		}
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
	 * Returns language table name
	 * @return mixed
	 */
	public function getLangTableName()
	{
		return $this->getConfigData('table') . '_Lang';
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
	public static function relations()
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
	 * Set validation error
	 */
	protected function setError($error) {
		$this->_errors[] = $error;
	}

	/**
	 * @return array validation errors
	 */
	public function getErrors() {
		return $this->_errors;
	}

	public function getRelated($alias, $params = [])
	{
		$relations = static::relations();

		if (isset($relations[$alias])) {
			$relation = $relations[$alias];

			switch ($relation['type']) {
				case 'has_many':
					return Orm::find($relation['targetClass'], [$relation['targetField']], [$this->getValue($relation['field'])], $params);
					break;

				case 'multiple':
					$related = PDO::getInstance()->rows('select ' . $relation['targetClass'] . '  from ' . $relation['table'] . ' where ' . $relation['class'] . ' = ' . $this->getId());
					return Orm::find($relation['targetClass'], ['id'], [array_column($related, $relation['targetClass'])], $params);
					break;

				case 'has_one':
				default:
					return Orm::load($relation['targetClass'], $this->getValue($relation['field']));
			}
		}

		return false;
	}

	/**
	 * Set multiple values
	 * @param $data
	 * @return $this
	 */
	public function setValues($data)
	{
		foreach ($data as $field => $value) {
			$this->setValue($field, $value);
		}

		return $this;
	}

	/**
	 * Sets object value
	 * @param string $field field name
	 * @param $value int value
	 */
	public function setValue($field, $value)
	{
		$allowedLanguageFields = $this->_checkLanguageFields();
		$this->_hasChanges = true;

		if (in_array($field, $allowedLanguageFields)) {
			$this->_values['languageTable'][$field] = $value;
		} else {
			$this->_values[$field] = $value;
		}
	}

	/**
	 * Returns existing language fields
	 * @return array
	 */
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
		return isset($this->_values[$field])
			? $this->_values[$field]
			: (isset($this->_values['languageTable'])
				? $this->_values['languageTable'][$field]
				: '');
	}

	/**
	 * Returns object id
	 * @return int
	 */
	public function getId()
	{
		return $this->getValue('id');
	}

	/**
	 * Returns object is new or already exists
	 * @return bool
	 */
	public function isNew()
	{
		return $this->getValue('id') ? false : true;
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

	/**
	 * Returns key -> value array with simple values
	 * Used in ORM
	 * @return array
	 */
	public function getSimpleFieldsData()
	{
		$data = [];
		$fields = array_keys($this->getConfigData('fields'));
		$values = $this->getValues();

		foreach ($values as $field => $value) {
			if (in_array($field, $fields)) {
				$data[$field] = $value;
			}
		}

		return $data;
	}

	/**
	 * Returns key -> value array with current language data
	 * Used in ORM
	 * @return array
	 */
	public function getLanguageFieldsData()
	{
		$langData = [];
		if ($langTableData = $this->getValue('languageTable')) {
			foreach ($langTableData as $field => $value) {
				$langData[] = ['field' => $field, 'value'=> $value];
			}
		}

		return $langData;
	}
}
