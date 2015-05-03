<?php

namespace Core;

use Core\Database\MySQL;

class Authorize
{
	const PASSWORD_SALT = '$WEujdgsju90w4j90';
	const HASH_SALT = 'KP(4yppeP(WY$il9-y';

	private $_entity;
	private $_user;

	public function __construct($entity)
	{
		$this->_entity = $entity;
	}

	public function login($login, $password, $hashfunction)
	{
		if ($user = Orm::findOne($this->_entity, ['login', 'password'], [$login, $hashfunction($password)])) {
			$hash = $this->hash($login, $password);
			$this->_user = $user;

			MySQL::insert('User_Session', ['entity' => $this->_entity, 'hash' => $hash, 'userId' => $this->_user->getId()]);
			Cookie::set('oauth_hash', $hash);
		}
	}

	public function logout()
	{
		MySQL::delete('User_Session', ['entity' => $this->_entity, 'userId' => $this->_user->getId()]);
		Cookie::remove('oauth_hash');
		$this->_user = null;
	}

	public function getUser()
	{
		if (!$this->_user) {
			$oauthHash = Cookie::get('oauth_hash');

			if ($session = Orm::findOne('User_Session', ['hash', 'entity'], [$oauthHash, $this->_entity])) {
				$this->_user = Orm::load($this->_entity, $session->getValue('userId'));
			}
		}

		return $this->_user;
	}

	protected function hash($login, $password)
	{
		return md5($this->_entity . $login . $password . self::HASH_SALT);
	}
}
