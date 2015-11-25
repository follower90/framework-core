Class [ <user> class Core\Socket\Server ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Socket/Server.php 5-35

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [2] {
    Property [ <default> private $_ip ]
    Property [ <default> private $_port ]
  }

  - Methods [2] {
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Socket/Server.php 10 - 14

      - Parameters [2] {
        Parameter #0 [ <required> $ip ]
        Parameter #1 [ <required> $port ]
      }
    }

    /**
	 * Run socket server
	 * @todo rewrite this piece of shit
	 * @throws \Exception if could not start socket stream
	 */
    Method [ <user> public method run ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Socket/Server.php 21 - 34
    }
  }
}
