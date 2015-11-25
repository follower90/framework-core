Class [ <user> class Core\Router ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 5-238

  - Constants [2] {
    Constant [ string NOT_AUTHORIZED ] { HTTP/1.1 401 Unauthorized }
    Constant [ string NOT_FOUND_404 ] { HTTP/1.0 404 Not Found }
  }

  - Static properties [4] {
    Property [ private static $_routes ]
    Property [ private static $_aliases ]
    Property [ private static $_url ]
    Property [ private static $_isApi ]
  }

  - Static methods [11] {
    /**
	 * Returns controller and method for executing
	 * by requested URI
	 * @param $lib
	 * @return array|bool
	 */
    Method [ <user> static public method getAction ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 22 - 45

      - Parameters [1] {
        Parameter #0 [ <required> $lib ]
      }
    }

    /**
	 * Defines custom alias url for controller
	 * @param string $url first url part
	 * @param string $controller class name
	 */
    Method [ <user> static public method alias ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 52 - 55

      - Parameters [2] {
        Parameter #0 [ <required> $url ]
        Parameter #1 [ <required> $controller ]
      }
    }

    /**
	 * Autodetect appropriate route
	 * @param $lib
	 * @return array|bool
	 */
    Method [ <user> static protected method _autoDetect ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 62 - 98

      - Parameters [1] {
        Parameter #0 [ <required> $lib ]
      }
    }

    /**
	 * Combines Uri params with GET and POST data
	 * @param $args
	 * @return array
	 */
    Method [ <user> static protected method getArgs ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 105 - 116

      - Parameters [1] {
        Parameter #0 [ <optional> $args = Array ]
      }
    }

    Method [ <user> static protected method _sanitize ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 118 - 121

      - Parameters [1] {
        Parameter #0 [ <required> $string ]
      }
    }

    /**
	 * Writes requested uri, based on site.url
	 * and 'isApi' = true, if Api request
	 * @return array
	 */
    Method [ <user> static protected method _initUrlParams ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 128 - 147
    }

    /**
	 * Register custom route
	 * @param $request
	 * @param $controller
	 * @param $action
	 * @param $params
	 */
    Method [ <user> static public method register ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 156 - 165

      - Parameters [4] {
        Parameter #0 [ <required> $request ]
        Parameter #1 [ <required> $controller ]
        Parameter #2 [ <required> $action ]
        Parameter #3 [ <required> $params ]
      }
    }

    /**
	 * Simple redirect to URI
	 * Accepts array of custom headers
	 * @param $url
	 * @param array $headers
	 */
    Method [ <user> static public method redirect ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 173 - 177

      - Parameters [2] {
        Parameter #0 [ <required> $url ]
        Parameter #1 [ <optional> $headers = Array ]
      }
    }

    /**
	 * Get Server Request params
	 * @param string $param
	 * @return string|bool
	 */
    Method [ <user> static public method get ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 184 - 199

      - Parameters [1] {
        Parameter #0 [ <required> $param ]
      }
    }

    /**
	 * Checks match requested URI with registered custom routes
	 * @param $route
	 * @param $url
	 * @return bool
	 */
    Method [ <user> static private method _matches ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 207 - 227

      - Parameters [2] {
        Parameter #0 [ <required> $route ]
        Parameter #1 [ <required> $url ]
      }
    }

    /**
	 * Sends http headers
	 * @param $headers
	 */
    Method [ <user> static public method sendHeaders ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Router.php 233 - 237

      - Parameters [1] {
        Parameter #0 [ <optional> $headers = Array ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [0] {
  }
}
