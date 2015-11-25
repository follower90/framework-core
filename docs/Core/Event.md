Class [ <user> class Core\Event ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Event.php 5-59

  - Constants [0] {
  }

  - Static properties [2] {
    Property [ private static $_handlers ]
    Property [ private static $_listeners ]
  }

  - Static methods [3] {
    /**
	 * Registering event handler
	 * @param EventHandler $handler
	 */
    Method [ <user> static public method registerHandler ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Event.php 14 - 19

      - Parameters [1] {
        Parameter #0 [ <required> Core\EventHandler $handler ]
      }
    }

    /**
	 * Dispatches event
	 * Can send data array and callback
	 * @param $alias
	 * @param array $data
	 * @param null $callback
	 */
    Method [ <user> static public method dispatch ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Event.php 28 - 45

      - Parameters [3] {
        Parameter #0 [ <required> $alias ]
        Parameter #1 [ <optional> $data = Array ]
        Parameter #2 [ <optional> $callback = NULL ]
      }
    }

    /**
	 * Subscribe for event and run callback function when event will be run
	 * @param $alias
	 * @param bool $callback
	 */
    Method [ <user> static public method listen ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Event.php 52 - 58

      - Parameters [2] {
        Parameter #0 [ <required> $alias ]
        Parameter #1 [ <optional> $callback = NULL ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [0] {
  }
}
