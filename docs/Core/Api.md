Class [ <user> class Core\Api extends Core\Controller ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Api.php 7-59

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [1] {
    /**
	 * Not authorized response
	 */
    Method [ <user> static public method notAuthorized ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Api.php 53 - 58
    }
  }

  - Properties [4] {
    Property [ <default> protected $request ]
    Property [ <default> protected $db ]
    Property [ <default> protected $view ]
    Property [ <default> protected $settings ]
  }

  - Methods [4] {
    /**
	 * Assigns PDO connection to protected variable
	 * for using in API Controllers
	 */
    Method [ <user, overwrites Core\Controller, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Api.php 15 - 19
    }

    /**
	 * Api run wrapper for response formatting
	 * and errors catching
	 * @param $method
	 * @param $args
	 * @return array
	 */
    Method [ <user, overwrites Core\Controller, prototype Core\Controller> public method run ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Api.php 28 - 48

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
    Method [ <user, inherits Core\Controller> public method request ] {
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
    Method [ <user, inherits Core\Controller> protected method execute ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Controller.php 62 - 76

      - Parameters [2] {
        Parameter #0 [ <required> $apiPath ]
        Parameter #1 [ <required> $arguments ]
      }
    }
  }
}
