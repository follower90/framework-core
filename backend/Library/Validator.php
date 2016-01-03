<?php

namespace Core;

/**
 * Class Validator
 * Simple validation
 * @todo integrate to \Core\Controller for input data validation
 * @package Core
 */
class Validator
{
	private $_rules = [];
	private $_request = [];

	/**
	 * Validation rules and methods list
	 * @todo extend with more validation capabilities
	 * @var array
	 */
	protected $_rulesList = [
		'required' => 'isNotEmpty',
		'text' => 'isText',
		'numeric' => '@todo',
		'email' => '@todo',
	];

	/**
	 * @param $rules array, example: [ 'test' => [ 'validator' => 'text', 'message' => 'Not a text' ]];
	 * @param $request array, example: [ 'test' => 2234 ];
	 * set rules and fields to $this
	 */
	public function __construct($rules, $request)
	{
		$this->_rules = $rules;
		$this->_request = $request;
	}

	/**
	 * Return result (success:true|false)
	 * and errors list (field => error_text), or empty array
	 * @return array
	 */
	public function validate()
	{
		$errors = [];

		foreach ($this->_rules as $alias => $rule) {
			$field = $this->_request[$alias];

			if (!$this->_validate($field, $rule['validator'])) {
				$errors[$alias] = $rule['message'];
			}
		}

		return [
			'success' => empty($errors) ? true : false,
			'errors' => $errors
		];
	}

	/**
	 * Applies validation method to the field according to the rule
	 * @param $field
	 * @param $rule
	 * @return bool
	 */
	protected function _validate($field, $rule)
	{
		return call_user_func([$this, $this->_rulesList[$rule]], $field);
	}

	/**
	 * Return false, if value is not set, or empty
	 * @param $val
	 * @return bool
	 */
	private function isNotEmpty($val)
	{
		if (isset($val) && !empty($val)) {
			return true;
		}

		return false;
	}

	/**
	 * Returns false, if value is not text string
	 * @param $val
	 * @return bool
	 */
	private function isText($val)
	{
		if (preg_match('^\w$/m', $val) == $val) {
			return true;
		}

		return false;
	}
}