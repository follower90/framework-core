Class [ <user> class Core\Database\QueryBuilder ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 5-385

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [1] {
    Property [ <default> private $_config ]
  }

  - Methods [20] {
    /**
	 * Set up base table and it's alias
	 * @param $table
	 */
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 13 - 17

      - Parameters [1] {
        Parameter #0 [ <required> $table ]
      }
    }

    /**
	 * Setups params for selections
	 * @param $field
	 * @param string $alias
	 * @param string $table
	 * @return $this
	 */
    Method [ <user> public method select ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 26 - 37

      - Parameters [3] {
        Parameter #0 [ <required> $field ]
        Parameter #1 [ <optional> $alias = '' ]
        Parameter #2 [ <optional> $table = '' ]
      }
    }

    /**
	 * Setups base table alias
	 * @param $alias
	 * @return $this
	 */
    Method [ <user> public method setBaseAlias ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 44 - 48

      - Parameters [1] {
        Parameter #0 [ <required> $alias ]
      }
    }

    /**
	 * Setups joins
	 * @param $type
	 * @param $table
	 * @param $alias
	 * @param $relations
	 * @return $this
	 */
    Method [ <user> public method join ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 58 - 71

      - Parameters [4] {
        Parameter #0 [ <required> $type ]
        Parameter #1 [ <required> $table ]
        Parameter #2 [ <required> $alias ]
        Parameter #3 [ <required> $relations ]
      }
    }

    /**
	 * Setups where conditions
	 * @param $value
	 * @param $args
	 * @param string $action
	 * @return $this
	 */
    Method [ <user> public method where ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 80 - 91

      - Parameters [3] {
        Parameter #0 [ <required> $value ]
        Parameter #1 [ <required> $args ]
        Parameter #2 [ <optional> $action = '=' ]
      }
    }

    /**
	 * Setups order by conditions
	 * @param $field
	 * @param string $direction
	 * @return $this
	 */
    Method [ <user> public method orderBy ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 99 - 109

      - Parameters [2] {
        Parameter #0 [ <required> $field ]
        Parameter #1 [ <optional> $direction = 'asc' ]
      }
    }

    /**
	 * Setups group by conditions
	 * @param $field
	 * @return $this
	 */
    Method [ <user> public method groupBy ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 116 - 125

      - Parameters [1] {
        Parameter #0 [ <required> $field ]
      }
    }

    /**
	 * Offset setup
	 * @param $value
	 * @return $this
	 */
    Method [ <user> public method offset ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 132 - 139

      - Parameters [1] {
        Parameter #0 [ <required> $value ]
      }
    }

    /**
	 * Limit setup
	 * @param $value
	 * @return $this
	 */
    Method [ <user> public method limit ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 146 - 153

      - Parameters [1] {
        Parameter #0 [ <required> $value ]
      }
    }

    /**
	 * Composes raw mysql query based on QueryBuilder setup
	 * @return string
	 */
    Method [ <user> public method composeSelectQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 159 - 164
    }

    /**
	 * Composes mysql query based on QueryBuilder setup for getting count of objects only
	 * @return string
	 */
    Method [ <user> public method composeSelectCountQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 170 - 174
    }

    Method [ <user> private method _composeQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 176 - 193

      - Parameters [1] {
        Parameter #0 [ <required> $query ]
      }
    }

    /**
	 * Fields composer
	 * @return array
	 */
    Method [ <user> private method _composeFields ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 199 - 226
    }

    /**
	 * Joins composer
	 * @return array
	 */
    Method [ <user> private method _composeJoins ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 232 - 246
    }

    /**
	 * Conditions composer
	 * @return array
	 */
    Method [ <user> private method _composeConditions ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 252 - 290
    }

    /**
	 * Order composer
	 * @return string
	 */
    Method [ <user> private method _composerOrder ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 296 - 312
    }

    /**
	 * Grouping composer
	 * @return string
	 */
    Method [ <user> private method _composeGrouping ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 318 - 333
    }

    /**
	 * Offset and limit composer
	 * @return string
	 */
    Method [ <user> private method _composeLimit ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 339 - 351
    }

    /**
	 * Returns QueryBuilder config data
	 * @param bool $section
	 * @return mixed
	 */
    Method [ <user> public method debug ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 358 - 365

      - Parameters [1] {
        Parameter #0 [ <optional> $section = false ]
      }
    }

    /**
	 * Applies table/param alias
	 * @param $value
	 * @return mixed|string
	 */
    Method [ <user> private method applyAlias ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/QueryBuilder.php 372 - 384

      - Parameters [1] {
        Parameter #0 [ <required> $value ]
      }
    }
  }
}
