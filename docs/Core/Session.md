Class [ <user> class Core\Session ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Session.php 5-43

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [4] {
    /**
	 * Session start wrapper
	 */
    Method [ <user> static public method init ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Session.php 10 - 13
    }

    /**
	 * Returns session param by key
	 * @param $key
	 * @return bool
	 */
    Method [ <user> static public method get ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Session.php 20 - 23

      - Parameters [1] {
        Parameter #0 [ <required> $key ]
      }
    }

    /**
	 * Sets session param
	 * @param $key
	 * @param $value
	 */
    Method [ <user> static public method set ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Session.php 30 - 33

      - Parameters [2] {
        Parameter #0 [ <required> $key ]
        Parameter #1 [ <required> $value ]
      }
    }

    /**
	 * Removes session param
	 * @param $key
	 */
    Method [ <user> static public method remove ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Session.php 39 - 42

      - Parameters [1] {
        Parameter #0 [ <required> $key ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [0] {
  }
}
