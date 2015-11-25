Class [ <user> abstract class Core\EntryPoint ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/EntryPoint.php 5-75

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [1] {
    Property [ <default> private $_lib ]
  }

  - Methods [6] {
    /**
	 * Abstract init method
	 * Must be defined in project entry points
	 * @return mixed
	 */
    Method [ <user> abstract public method init ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/EntryPoint.php 14 - 14
    }

    /**
	 * Default output method
	 * Can be overridden with any data transformation
	 * @param $data
	 * @return mixed
	 */
    Method [ <user> public method output ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/EntryPoint.php 22 - 25

      - Parameters [1] {
        Parameter #0 [ <required> $data ]
      }
    }

    /**
	 * Return namespace name. Must to have been set at first
	 * @return mixed
	 * @throws \Exception
	 */
    Method [ <user> public method getLib ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/EntryPoint.php 32 - 39
    }

    /**
	 * Set method for setting project namespace
	 * @param $path
	 */
    Method [ <user> protected method setLib ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/EntryPoint.php 45 - 48

      - Parameters [1] {
        Parameter #0 [ <required> $path ]
      }
    }

    /**
	 * Returns POST and GET params merged together
	 * @param bool $key
	 * @return array|bool
	 */
    Method [ <user> public method request ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/EntryPoint.php 55 - 64

      - Parameters [1] {
        Parameter #0 [ <optional> $key = false ]
      }
    }

    /**
	 * Allows debug mode
	 * Can be overridden in site entry points
	 * @return bool
	 */
    Method [ <user> public method debug ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/EntryPoint.php 71 - 74
    }
  }
}
