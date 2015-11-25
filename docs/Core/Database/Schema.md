Class [ <user> class Core\Database\Schema ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/Schema.php 8-177

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [4] {
    /**
	 * Process launch method, setups for wiping database
	 * @param array $path
	 * @param array $params
	 */
    Method [ <user> static public method createObjects ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/Schema.php 30 - 39

      - Parameters [2] {
        Parameter #0 [ <optional> $path = Array ]
        Parameter #1 [ <optional> $params = Array ]
      }
    }

    /**
	 * Creates table by object name
	 * @param array $name
	 * @param array $params
	 */
    Method [ <user> static public method createObject ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/Schema.php 46 - 54

      - Parameters [2] {
        Parameter #0 [ <required> $name ]
        Parameter #1 [ <optional> $params = Array ]
      }
    }

    /**
	 * Launches table rebuilding for all objects in defined path
	 * @param $rootPath
	 * @param array $params
	 * @throws \Core\Object
	 */
    Method [ <user> static private method _createObjects ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/Schema.php 95 - 119

      - Parameters [2] {
        Parameter #0 [ <required> $rootPath ]
        Parameter #1 [ <optional> $params = Array ]
      }
    }

    /**
	 * Drops all tables in database
	 */
    Method [ <user> static private method _dropTables ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/Schema.php 159 - 176
    }
  }

  - Properties [3] {
    Property [ <default> private $_object ]
    Property [ <default> private $_table ]
    Property [ <default> private $_fields ]
  }

  - Methods [3] {
    /**
	 * Setups object table and fields
	 * @param \Core\Object $object
	 */
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/Schema.php 18 - 23

      - Parameters [1] {
        Parameter #0 [ <required> Core\Object $object ]
      }
    }

    /**
	 * Rebuilds table for object, rebuild param drops existing tables
	 * @param bool $rebuild
	 */
    Method [ <user> public method create ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/Schema.php 60 - 87

      - Parameters [1] {
        Parameter #0 [ <optional> $rebuild = false ]
      }
    }

    /**
	 * Prepares fields for creating table
	 * @return string
	 */
    Method [ <user> private method _prepareFields ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/Schema.php 125 - 154
    }
  }
}
