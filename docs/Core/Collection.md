Class [ <user> class Core\Collection ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 7-114

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [1] {
    Property [ <default> protected $_objects ]
  }

  - Methods [9] {
    /**
	 * Sets objects array to collection
	 * @param $array
	 */
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 15 - 18

      - Parameters [1] {
        Parameter #0 [ <required> $array ]
      }
    }

    /**
	 * Return array of objects
	 * @return array
	 */
    Method [ <user> public method getCollection ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 24 - 27
    }

    /**
	 * Returns associative data map with keys of objects ids
	 * @return array
	 */
    Method [ <user> public method getData ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 33 - 41
    }

    /**
	 * Return array map of objects values
	 * @param $key
	 * @param $value
	 * @return array
	 */
    Method [ <user> public method getHashMap ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 49 - 58

      - Parameters [2] {
        Parameter #0 [ <required> $key ]
        Parameter #1 [ <required> $value ]
      }
    }

    /**
	 * Returns object values by concrete field
	 * @param $field
	 * @return array
	 */
    Method [ <user> public method getValues ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 65 - 73

      - Parameters [1] {
        Parameter #0 [ <required> $field ]
      }
    }

    /**
	 * Returns count of objects in collection
	 * @return int
	 */
    Method [ <user> public method getCount ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 79 - 82
    }

    /**
	 * Returns first object of collection
	 * @return \Core\Object|bool
	 */
    Method [ <user> public method getFirst ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 88 - 95
    }

    /**
	 * Returns true if collection is empty
	 * @return bool
	 */
    Method [ <user> public method isEmpty ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 101 - 104
    }

    /**
	 * Returns collection steam
	 * @return Stream
	 */
    Method [ <user> public method stream ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Collection.php 110 - 113
    }
  }
}
