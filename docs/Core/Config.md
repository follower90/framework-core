Class [ <user> class Core\Config ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Config.php 5-95

  - Constants [0] {
  }

  - Static properties [1] {
    Property [ private static $config ]
  }

  - Static methods [6] {
    /**
	 * Get default database connection
	 * @todo refactor for use different connections with different projects / objects
	 * @return mixed
	 */
    Method [ <user> static public method dbConnection ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Config.php 14 - 17
    }

    /**
	 * Set path to templates folder
	 * @todo refactor for using with multiple projects and templates folders location
	 * @return mixed
	 */
    Method [ <user> static public method tplSettings ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Config.php 24 - 27
    }

    /**
	 * Get config param by key, or get whole config array
	 * @param $item
	 * @return array
	 */
    Method [ <user> static public method get ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Config.php 34 - 53

      - Parameters [1] {
        Parameter #0 [ <required> $item ]
      }
    }

    /**
	 * Register project with its namespace
	 * @param $project
	 * @param $connection
	 */
    Method [ <user> static public method registerProject ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Config.php 60 - 66

      - Parameters [2] {
        Parameter #0 [ <required> $project ]
        Parameter #1 [ <required> $connection ]
      }
    }

    /**
	 * Set database connection params
	 * @param $alias
	 * @param $config
	 */
    Method [ <user> static public method setDb ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Config.php 73 - 76

      - Parameters [2] {
        Parameter #0 [ <required> $alias ]
        Parameter #1 [ <required> $config ]
      }
    }

    /**
	 * Set custom property to Config
	 * @param $item
	 * @param $value
	 */
    Method [ <user> static public method set ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Config.php 83 - 94

      - Parameters [2] {
        Parameter #0 [ <required> $item ]
        Parameter #1 [ <required> $value ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [0] {
  }
}
