Class [ <user> class Core\OrmMapper ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 5-224

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [1] {
    /**
	 * Creates new OrmMapper
	 * @param $class
	 * @return \Core\OrmMapper
	 * @throws \Exception
	 */
    Method [ <user> static public method create ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 36 - 40

      - Parameters [1] {
        Parameter #0 [ <required> $class ]
      }
    }
  }

  - Properties [9] {
    Property [ <default> private $_collection ]
    Property [ <default> private $_object ]
    Property [ <default> private $_fields ]
    Property [ <default> private $_filters ]
    Property [ <default> private $_offset ]
    Property [ <default> private $_sorting ]
    Property [ <default> private $_limit ]
    Property [ <default> private $_map ]
    Property [ <default> private $_allowedFields ]
  }

  - Methods [11] {
    /**
	 * Private constructor
	 * Sets class and gets object configs
	 * @param $class
	 */
    Method [ <user, ctor> private method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 23 - 28

      - Parameters [1] {
        Parameter #0 [ <required> $class ]
      }
    }

    /**
	 * Returns object collection
	 * @return \Core\Collection
	 */
    Method [ <user> public method getCollection ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 46 - 49
    }

    /**
	 * Sets fields for getting
	 * @todo fix for getting related fields
	 * @param $fields
	 * @return \Core\OrmMapper
	 */
    Method [ <user> public method setFields ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 57 - 70

      - Parameters [1] {
        Parameter #0 [ <required> $fields ]
      }
    }

    /**
	 * Set ordering
	 * @param $field
	 * @param string $sort
	 * @return \Core\OrmMapper
	 */
    Method [ <user> public method setSorting ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 78 - 82

      - Parameters [2] {
        Parameter #0 [ <required> $field ]
        Parameter #1 [ <optional> $sort = 'asc' ]
      }
    }

    /**
	 * Set filter conditions
	 * @param $keys
	 * @param $values
	 * @return \Core\OrmMapper
	 */
    Method [ <user> public method setFilter ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 90 - 100

      - Parameters [2] {
        Parameter #0 [ <required> $keys ]
        Parameter #1 [ <required> $values ]
      }
    }

    /**
	 * Add single filter conditions
	 * @param $key
	 * @param $value
	 * @return \Core\OrmMapper
	 */
    Method [ <user> public method addFilter ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 108 - 113

      - Parameters [2] {
        Parameter #0 [ <required> $key ]
        Parameter #1 [ <required> $value ]
      }
    }

    /**
	 * Set offset
	 * @param $offset
	 * @return \Core\OrmMapper
	 */
    Method [ <user> public method setOffset ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 120 - 124

      - Parameters [1] {
        Parameter #0 [ <required> $offset ]
      }
    }

    /**
	 * Set limit
	 * @param $limit
	 * @return \Core\OrmMapper
	 */
    Method [ <user> public method setLimit ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 131 - 135

      - Parameters [1] {
        Parameter #0 [ <required> $limit ]
      }
    }

    /**
	 * Load mapper with set params
	 * @return \Core\Collection
	 */
    Method [ <user> public method load ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 141 - 156
    }

    /**
	 * Returns simple array values map
	 * @return array
	 * @throws \Exception
	 */
    Method [ <user> public method getDataMap ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 163 - 195
    }

    /**
	 * Get related mapper by object relation
	 * @param $alias
	 * @return bool|OrmMapper
	 */
    Method [ <user> public method getRelatedMapper ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/OrmMapper.php 202 - 223

      - Parameters [1] {
        Parameter #0 [ <required> $alias ]
      }
    }
  }
}
