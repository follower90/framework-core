Class [ <user> class Core\OrmCache ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmCache.php 5-48

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [1] {
    /**
	 * Hash orm query params
	 * @param $params
	 * @return string
	 */
    Method [ <user> static private method _hashParams ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmCache.php 44 - 47

      - Parameters [1] {
        Parameter #0 [ <required> $params ]
      }
    }
  }

  - Properties [1] {
    Property [ <default> private $_data ]
  }

  - Methods [3] {
    /**
	 * Insert collection to hash
	 * @param $params
	 * @param $data
	 */
    Method [ <user> public method update ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmCache.php 14 - 18

      - Parameters [2] {
        Parameter #0 [ <required> $params ]
        Parameter #1 [ <required> $data ]
      }
    }

    /**
	 * Get collection by hash
	 * @param $params
	 * @return bool
	 */
    Method [ <user> public method get ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmCache.php 25 - 29

      - Parameters [1] {
        Parameter #0 [ <required> $params ]
      }
    }

    /**
	 * Clear orm cache
	 */
    Method [ <user> public method clear ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmCache.php 34 - 37
    }
  }
}
