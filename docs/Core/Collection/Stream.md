Class [ <user> class Core\Collection\Stream ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection/Stream.php 7-86

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [2] {
    Property [ <default> private $_objects ]
    Property [ <default> private $_stream ]
  }

  - Methods [7] {
    /**
	 * Sets array of objects to new stream
	 * @param array $objects
	 */
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection/Stream.php 16 - 20

      - Parameters [1] {
        Parameter #0 [ <required> $objects ]
      }
    }

    /**
	 * Applies function filter for stream filtering
	 * @param $callback
	 * @return $this
	 */
    Method [ <user> public method filter ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection/Stream.php 27 - 38

      - Parameters [1] {
        Parameter #0 [ <required> $callback ]
      }
    }

    /**
	 * Reassigns filtered stream to collection
	 */
    Method [ <user> private method _purgeSteam ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection/Stream.php 43 - 49
    }

    /**
	 * Returns first element of stream
	 * @return bool
	 */
    Method [ <user> public method findFirst ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection/Stream.php 55 - 58
    }

    /**
	 * Return all stream
	 * @return array|Collection
	 */
    Method [ <user> public method find ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection/Stream.php 64 - 67
    }

    /**
	 * Returns true if stream is empty
	 * @return bool
	 */
    Method [ <user> public method isEmpty ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection/Stream.php 73 - 76
    }

    /**
	 * Returns count of objects in the stream
	 * @return int
	 */
    Method [ <user> public method size ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection/Stream.php 82 - 85
    }
  }
}
