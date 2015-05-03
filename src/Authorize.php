<?php

namespace Core;

use Core\Database\MySQL;

class Authorize
{
	const PASSWORD_SALT = '$WEujdgsju90w4j90';
	const HASH_SALT = 'KP(4yppeP(WY$il9-y';

	private $_entity;
	private $_hash;
	private $_user;

	public function __construct($entity)
	{
		$this->_entity = $entity;
	}

	public function login($login, $password)
	{
		if ($user = Orm::fineOne($this->_entity, ['login', 'password'], [$login, static::passwordHash($password)])) {
			
			$this->_hash = $this->hash($login, $password);
			$this->_user = $user;

			MySQL::insert('User_Session', ['entity' => $this->_entity, 'hash' => $this->_hash]);
			Cookie::set('oauth_hash', $this->_hash);
		}
	}

	public function logout()
	{
		MySQL::delete('User_Session', ['entity' => $this->_entity, 'hash' => $hash]);
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

	public static function passwordHash($password)
	{
		return md5($password . static::PASSWORD_SALT);
	}

	protected function hash($login, $password)
	{
		return md5($this->_entity . $login . $password . static::HASH_SALT);
	}
}
