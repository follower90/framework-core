Trait [ <user> trait Core\Traits\Object\ActiveRecord ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 8-104

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [5] {
    /**
	 * Returns orm mapper for object
	 * @return OrmMapper
	 */
    Method [ <user> static public method all ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 14 - 17
    }

    /**
	 * Returns new user object
	 * @return Object
	 */
    Method [ <user> static public method create ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 23 - 26
    }

    /**
	 * ActiveRecord-like syntax sugar
	 * @param int $id
	 * @return bool|\Core\Object
	 */
    Method [ <user> static public method find ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 52 - 55

      - Parameters [1] {
        Parameter #0 [ <required> $id ]
      }
    }

    /**
	 * ActiveRecord-like syntax sugar
	 * @param $params
	 * @return bool|Collection
	 */
    Method [ <user> static public method findBy ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 62 - 65

      - Parameters [1] {
        Parameter #0 [ <required> $params ]
      }
    }

    /**
	 * ActiveRecord-like syntax sugar
	 * @param $params
	 * @return bool|Collection
	 */
    Method [ <user> static public method where ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 73 - 79

      - Parameters [1] {
        Parameter #0 [ <required> $params ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [4] {
    /**
	 * Syntax sugar, just saves object with Orm
	 * @throws \Exception
	 */
    Method [ <user> public method save ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 32 - 35
    }

    /**
	 * Syntax sugar, just deletes object with Orm
	 * @throws \Exception
	 */
    Method [ <user> public method delete ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 41 - 44
    }

    /**
	 * Syntax sugar method
	 * Sets arguments using magic method
	 * for use setValue method like direct property
	 * @param attr
	 * @param value
	 */
    Method [ <user> public method __set ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 88 - 91

      - Parameters [2] {
        Parameter #0 [ <required> $attr ]
        Parameter #1 [ <required> $value ]
      }
    }

    /**
	 * Syntax sugar method
	 * Returns value using magic method
	 * for use getValue method like direct property
	 * @param attr
	 * @return OrmMapper
	 */
    Method [ <user> public method __get ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Object/ActiveRecord.php 100 - 103

      - Parameters [1] {
        Parameter #0 [ <required> $attr ]
      }
    }
  }
}
