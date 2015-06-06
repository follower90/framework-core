<?php

namespace Core;

use Core\Database\MySQL;

class Authorize
{
	const HASH_SALT = 'KP(4yppeP(WY$il9-y';

	private $_entity;
	private $_user;

	/**
	 * Setups user authorizing entity, as string (Object name)
	 * @param $entity
	 */
	public function __construct($entity)
	{
		$this->_entity = $entity;
	}

	/**
	 * Login method
	 * Accepts login, password and hash function for password security
	 * Inserts user session hash to database and sets appropriate cookie
	 * @param $login
	 * @param $password
	 * @param $hashFunction
	 * @throws \Exception
	 */
	public function login($login, $password, $hashFunction)
	{
		if ($user = Orm::findOne($this->_entity, ['login', 'password'], [$login, $hashFunction($password)])) {
			$hash = $this->hash($login, $password);
			$this->_user = $user;

			MySQL::insert('User_Session', ['entity' => $this->_entity, 'hash' => $hash, 'userId' => $this->_user->getId()]);
			Cookie::set(strtolower($this->_entity) .'_oauth_hash', $hash);
		}
	}

	/**
	 * Removes user session hash from database
	 * and deletes auth cookie
	 * @throws \Exception
	 */
	public function logout()
	{
		if ($this->_user = $this->getUser()) {
			MySQL::delete('User_Session', ['entity' => $this->_entity, 'userId' => $this->_user->getId()]);
			Cookie::remove(strtolower($this->_entity) . '_oauth_hash');
			$this->_user = null;
		}
	}

	/**
	 * Returns authorized user
	 * If user isn't set globally to App, requests from user session table by auth cookie
	 * And sets authorized user to App
	 * @return bool|Object
	 */
	public function getUser()
	{
		if ($user = App::getUser()) {
			$this->_user = $user;
		}

		if (!$this->_user) {
			$oauthHash = Cookie::get(strtolower($this->_entity) . '_oauth_hash');

			if ($session = Orm::findOne('User_Session', ['hash', 'entity'], [$oauthHash, $this->_entity])) {
				$this->_user = Orm::load($this->_entity, $session->getValue('userId'));
				App::setUser($this->_user);
			}
		}

		return $this->_user;
	}

	/**
	 * Hash function for security of user session hash and auth cookie value
	 * @param $login
	 * @param $password
	 * @return string
	 */
	protected function hash($login, $password)
	{
		return md5($this->_entity . $login . $password . self::HASH_SALT);
	}
}
