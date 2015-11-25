Class [ <user> class Core\Controller ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Controller.php 6-77

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [3] {
    Property [ <default> protected $db ]
    Property [ <default> protected $view ]
    Property [ <default> protected $settings ]
  }

  - Methods [4] {
    /**
	 * Assigns PDO Mysql connection to protected variable
	 * Assigns View object for templates rendering
	 */
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Controller.php 16 - 20
    }

    /**
	 * Controllers run wrapper
	 * for error catching
	 * @param $method
	 * @param $args
	 * @return mixed
	 */
    Method [ <user> public method run ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Controller.php 29 - 36

      - Parameters [2] {
        Parameter #0 [ <required> $method ]
        Parameter #1 [ <required> $args ]
      }
    }

    /**
	 * Helper method for get POST and GET request variables
	 * @param bool $key
	 * @return array|bool
	 */
    Method [ <user> public method request ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Controller.php 43 - 52

      - Parameters [1] {
        Parameter #0 [ <optional> $key = false ]
      }
    }

    /**
	 * Api/Controller method executor
	 * For running one controller's method from another and avoid code duplication
	 * @param $apiPath
	 * @param $arguments
	 * @return mixed
	 * @throws \Exception
	 */
    Method [ <user> protected method execute ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Controller.php 62 - 76

      - Parameters [2] {
        Parameter #0 [ <required> $apiPath ]
        Parameter #1 [ <required> $arguments ]
      }
    }
  }
}
