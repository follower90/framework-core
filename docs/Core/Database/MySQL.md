Class [ <user> class Core\Database\MySQL ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/MySQL.php 5-99

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [5] {
    /**
	 * Runs Mysql update query
	 * @param $table
	 * @param array $params
	 * @param array $conditions
	 * @throws \Exception
	 */
    Method [ <user> static public method update ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/MySQL.php 14 - 33

      - Parameters [3] {
        Parameter #0 [ <required> $table ]
        Parameter #1 [ <optional> $params = Array ]
        Parameter #2 [ <optional> $conditions = Array ]
      }
    }

    /**
	 * Runs Mysql insert query
	 * @param $table
	 * @param array $params
	 * @return int $insertId
	 * @throws \Exception
	 */
    Method [ <user> static public method insert ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/MySQL.php 42 - 56

      - Parameters [2] {
        Parameter #0 [ <required> $table ]
        Parameter #1 [ <optional> $params = Array ]
      }
    }

    /**
	 * Deletes from table with specified conditions
	 * @param $table
	 * @param array $conditions
	 * @throws \Exception
	 */
    Method [ <user> static public method delete ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/MySQL.php 64 - 78

      - Parameters [2] {
        Parameter #0 [ <required> $table ]
        Parameter #1 [ <optional> $conditions = Array ]
      }
    }

    /**
	 * Runs RAW Mysql query without any conversions
	 * @param $query
	 * @return int success
	 */
    Method [ <user> static public method query ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/MySQL.php 85 - 88

      - Parameters [1] {
        Parameter #0 [ <required> $query ]
      }
    }

    /**
	 * Runs RAW Mysql query without any conversions
	 * @param $query
	 * @return Array result of query
	 */
    Method [ <user> static public method row ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/MySQL.php 95 - 98

      - Parameters [1] {
        Parameter #0 [ <required> $query ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [0] {
  }
}
