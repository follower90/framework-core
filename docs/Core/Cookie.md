Class [ <user> class Core\Cookie ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Cookie.php 5-39

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [3] {
    /**
	 * Returns cookie by its name
	 * @param $key
	 * @return bool
	 */
    Method [ <user> static public method get ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Cookie.php 12 - 15

      - Parameters [1] {
        Parameter #0 [ <required> $key ]
      }
    }

    /**
	 * Set-cookie helper
	 * By default sets cookie on root domain for 1 year period
	 * @param $name
	 * @param $value
	 * @param int $expire
	 * @param string $path
	 * @param null $domain
	 */
    Method [ <user> static public method set ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Cookie.php 26 - 29

      - Parameters [5] {
        Parameter #0 [ <required> $name ]
        Parameter #1 [ <required> $value ]
        Parameter #2 [ <optional> $expire = 31536000 ]
        Parameter #3 [ <optional> $path = '/' ]
        Parameter #4 [ <optional> $domain = NULL ]
      }
    }

    /**
	 * Removes cookie by setting expired till time
	 * @param $name
	 */
    Method [ <user> static public method remove ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Cookie.php 35 - 38

      - Parameters [1] {
        Parameter #0 [ <required> $name ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [0] {
  }
}
