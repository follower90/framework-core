/**
 * Class Authorize
 * Universal authorization class
 * Implements login, logout, and check authorization status
 *
 * @package Core
 */
Class [ <user> class Core\Authorize ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Authorize.php 15-133

  - Constants [1] {
    Constant [ string HASH_SALT ] { KP(4yppeP(WY$il9-y }
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [3] {
    Property [ <default> private $_entity ]
    Property [ <default> private $_user ]
    Property [ <default> private $_oauth_hash ]
  }

  - Methods [5] {
    /**
	 * Setups user authorizing entity, as string (Object name)
	 * @param $entity
	 */
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Authorize.php 41 - 49

      - Parameters [1] {
        Parameter #0 [ <required> $entity ]
      }
    }

    /**
	 * Login method
	 * Accepts login, password and hash function for password security
	 * Inserts user session hash to database and sets appropriate cookie
	 *
	 * @param string $login
	 * @param string $password
	 * @param \Closure $hashFunction
	 * @param bool $remember
	 * @throws \Exception
	 */
    Method [ <user> public method login ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Authorize.php 62 - 84

      - Parameters [4] {
        Parameter #0 [ <required> $login ]
        Parameter #1 [ <required> $password ]
        Parameter #2 [ <required> $hashFunction ]
        Parameter #3 [ <optional> $remember = false ]
      }
    }

    /**
	 * Removes user session hash from database
	 * and deletes auth cookie
	 *
	 * @throws \Exception
	 */
    Method [ <user> public method logout ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Authorize.php 92 - 102
    }

    /**
	 * Returns authorized user
	 * If user isn't set globally to App, requests from user session table by auth cookie
	 * And sets authorized user to App
	 *
	 * @return bool|Object
	 */
    Method [ <user> public method getUser ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Authorize.php 111 - 121
    }

    /**
	 * Hash function for security of user session hash and auth cookie value
	 * @param $login
	 * @param $password
	 * @return string
	 */
    Method [ <user> protected method hash ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Authorize.php 129 - 132

      - Parameters [2] {
        Parameter #0 [ <required> $login ]
        Parameter #1 [ <required> $password ]
      }
    }
  }
}
