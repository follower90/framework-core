<?php

namespace Core;

use Core\Database\MySQL;

/**
 * Class Authorize
 * Universal authorization class
 * Implements login, logout, and check authorization status
 *
 * @package Core
 */
class Authorize
{
	const HASH_SALT = 'KP(4yppeP(WY$il9-y';

	/**
	 * User entity name
	 * @var string
	 */
	private $_entity;

	/**
	 * User object
	 * @var \Core\Object
	 */
	private $_user;

	/**
	 * Hash string
	 * @var \Core\Object
	 */
	private $_oauth_hash;

	/**
	 * Setups user authorizing entity, as string (Object name)
	 * @param $entity
	 */
	public function __construct($entity)
	{
		$this->_entity = $entity;
		$this->_oauth_hash = Session::get(strtolower($this->_entity) .'_oauth_hash');

		if (!$this->_oauth_hash) {
			$this->_oauth_hash = Cookie::get(strtolower($this->_entity) .'_oauth_hash');
		}
	}

	/**
	 * Login method
	 * Accepts login, password and hash function for password security
	 * Inserts user session hash to database and sets appropriate cookie
	 *
	 * @param $login
	 * @param $password
	 * @param $hashFunction
	 * @throws \Exception
	 */
	public function login($login, $password, $hashFunction, $remember = false)
	{
		if ($user = Orm::findOne($this->_entity, ['login', 'password'], [$login, $hashFunction($password)])) {
			$this->_oauth_hash = $this->hash($login, $password);
			$this->_user = $user;

			MySQL::insert('User_Session', ['entity' => $this->_entity, 'hash' => $this->_oauth_hash, 'userId' => $this->_user->getId()]);
			Session::set(strtolower($this->_entity) .'_oauth_hash', $this->_oauth_hash);

			if ($remember) {
				Cookie::set(strtolower($this->_entity) .'_oauth_hash', $this->_oauth_hash);
			}
		}
	}

	/**
	 * Removes user session hash from database
	 * and deletes auth cookie
	 *
	 * @throws \Exception
	 */
	public function logout()
	{
		Cookie::remove(strtolower($this->_entity) . '_oauth_hash');
		if ($this->_user = $this->getUser()) {
			MySQL::delete('User_Session', ['entity' => $this->_entity, 'userId' => $this->_user->getId()]);
			Cookie::remove(strtolower($this->_entity) . '_oauth_hash');
			Session::remove(strtolower($this->_entity) . '_oauth_hash');
			$this->_user = null;
		}
	}

	/**
	 * Returns authorized user
	 * If user isn't set globally to App, requests from user session table by auth cookie
	 * And sets authorized user to App
	 *
	 * @return bool|Object
	 */
	public function getUser()
	{
		if ($user = App::getUser()) {
			$this->_user = $user;
		}

		if (!$this->_user) {
			if ($session = Orm::findOne('User_Session', ['hash', 'entity'], [$this->_oauth_hash, $this->_entity])) {
				$this->_user = Orm::load($this->_entity, $session->getValue('userId'));
				App::setUser($this->_user);
			}
		}

		return $this->_user;
	}

	/**
	 * Hash function for security of user session hash and auth cookie value
	 *
	 * @param $login
	 * @param $password
	 * @return string
	 */
	protected function hash($login, $password)
	{
		return md5($this->_entity . $login . $password . self::HASH_SALT);
	}
}
