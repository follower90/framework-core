<?php

namespace Core;

use Core\Database\MySQL;
use Core\Database\PDO;

abstract class Object
{
	use Traits\Object\Hooks;
	use Traits\Object\ActiveRecord;

	protected $_table;
	protected $_class;
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
		$this->_class = $this->getClassName();

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
	 * Set validation error
	 */
	protected function setError($error) {
		$this->_errors[] = $error;
	}

	/**
	 * @return validation errors
	 */
	public function getErrors() {
		return $this->_errors;
	}

	/**
	 * Trigger callback for event
	 * if it was registered
	 * @param string $alias
	 */
	public function triggerEvent($alias)
	{
		$callback = isset(self::$_events[$alias]) ? self::$_events[$alias] : false;
		if ($callback) {
			call_user_func($hook);
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

	public function getRelated($alias)
	{
		$relations = $this->relations();

		if (isset($relations[$alias])) {
			$relation = $relations[$alias];

			if (!isset($relation['type']) || $relation['type'] !== 'multiple') {
				return Orm::load($relation['targetClass'], $this->getValue($relation['field']));
			} else {
				$related = PDO::getInstance()->rows('select ' . $relation['targetClass'] . '  from ' . $relation['table'] . ' where ' . $relation['class'] . ' = ' . $this->getId());
				return Orm::find($relation['targetClass'], ['id'], [array_column($related, $relation['targetClass'])]);
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

		return $this;
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
			$this->triggerEvent($field . 'Changed');
			$this->_hasChanges = true;
		}

		if (in_array($field, $allowedLanguageFields)) {
			$this->_values['languageTable'][$field] = $value;
			$this->triggerEvent($field . 'Changed');
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
			return isset($this->_values[$field])
				? $this->_values[$field]
				: (isset($this->_values['languageTable'])
					? $this->_values['languageTable'][$field]
					: '');
		}

		return false;
	}

	/**
	 * return related object by relation alias
	 * todo - refactor this shit
	 * @param $alias
	 * @return bool|Object
	 */
	public function getRelatedObject($alias)
	{
		$relations = $this->relations();
		foreach ($relations as $key => $relation) {

			if ($key == $alias) {
				$query = 'select * FROM `'.$relation['class'].'` a
				inner join '.$relation['table'].' b on a.id = b.'.$relation['class'].'
				where b.'.$relation['targetClass'].' = '.$this->getId().'';

				$result = MySQL::row($query);

				if ($result) {
					return Orm::load($relation['class'], $result['id']);
				}
			}
		}

		return false;
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
		$fields = array_filter($this->getConfigData('fields'), function($field) {
			return !in_array($field['type'], ['HAS_MANY']);
		});

		foreach ($this->getValues() as $field => $value) {
			if (in_array($field, array_keys($fields))) {
				$data[$field] = $value;
			}
		}

		return $data;
	}

	/**
	 * Returns key -> value array with HAS_MANY relation values
	 * todo refactor this shit
	 * Used in ORM
	 * @return array
	 */
	public function getHasManyRelationFieldsData()
	{
		$data = [];
		$fields = array_filter($this->getConfigData('fields'), function($field) {
			return in_array($field['type'], ['HAS_MANY']);
		});

		foreach ($this->getValues() as $field => $value) {
			if (in_array($field, array_keys($fields))) {
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
