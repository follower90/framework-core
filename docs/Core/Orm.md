Class [ <user> class Core\Orm ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 10-288

  - Constants [0] {
  }

  - Static properties [2] {
    Property [ protected static $_object ]
    Property [ protected static $_cache ]
  }

  - Static methods [20] {
    /**
	 * Creates and returns new Object
	 * @param $class
	 * @return \Core\Object
	 */
    Method [ <user> static public method create ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 22 - 25

      - Parameters [1] {
        Parameter #0 [ <required> $class ]
      }
    }

    /**
	 * Saves object to database
	 * @param \Core\Object $object
	 * @return bool
	 * @throws \Exception
	 */
    Method [ <user> static public method save ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 33 - 67

      - Parameters [1] {
        Parameter #0 [ <required> Core\Object &$object ]
      }
    }

    /**
	 * Load objects collection from database
	 * @param $class
	 * @param array $filters
	 * @param array $values
	 * @param array $params
	 * @return bool|\Core\Collection
	 */
    Method [ <user> static public method find ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 77 - 105

      - Parameters [4] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <optional> $filters = Array ]
        Parameter #2 [ <optional> $values = Array ]
        Parameter #3 [ <optional> $params = Array ]
      }
    }

    /**
	 * Returns count of requested object
	 * @param $class
	 * @param array $filters
	 * @param array $values
	 * @return int
	 */
    Method [ <user> static public method count ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 114 - 127

      - Parameters [3] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <optional> $filters = Array ]
        Parameter #2 [ <optional> $values = Array ]
      }
    }

    /**
	 * Find first object by given parameters
	 * @param $class
	 * @param array $filters
	 * @param array $values
	 * @return \Core\Object
	 */
    Method [ <user> static public method findOne ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 136 - 140

      - Parameters [3] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <optional> $filters = Array ]
        Parameter #2 [ <optional> $values = Array ]
      }
    }

    /**
	 * Load object by its id
	 * @param $class
	 * @param $id
	 * @return \Core\Object or false
	 */
    Method [ <user> static public method load ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 148 - 151

      - Parameters [2] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <required> $id ]
      }
    }

    /**
	 * Deletes object from database
	 * @param \Core\Object $object
	 * @return bool
	 * @throws \Exception
	 */
    Method [ <user> static public method delete ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 159 - 171

      - Parameters [1] {
        Parameter #0 [ <required> Core\Object $object ]
      }
    }

    /**
	 * Cleans orm cache
	 */
    Method [ <user> static public method clearCache ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 176 - 179
    }

    /**
	 * returns or creates single Cache object
	 * @return OrmCache
	 */
    Method [ <user> static private method getOrmCache ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 185 - 192
    }

    /**
	 * @param [type, alias, ...] $relationProperties
	 * @param $targetObjectProperties
	 * @param $relatedObjectProperties
	 * @throws \Exception if target object is illegal
	 */
    Method [ <user> static public method registerRelation ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 200 - 220

      - Parameters [3] {
        Parameter #0 [ <required> $relationProperties ]
        Parameter #1 [ <required> $targetObjectProperties ]
        Parameter #2 [ <required> $relatedObjectProperties ]
      }
    }

    /**
	 * Returns full class name with namespaces from registered projects by given object name
	 * @param $class
	 * @return string
	 * @throws \Exception
	 */
    Method [ <user> static public method detectClass ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 228 - 245

      - Parameters [1] {
        Parameter #0 [ <required> $class ]
      }
    }

    /**
	 * Returns new object by requested class name
	 * @param $class string object name
	 * @return \Core\Object
	 * @throws \Exception in detectClass method
	 */
    Method [ <user> static protected method _getObject ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 253 - 260

      - Parameters [1] {
        Parameter #0 [ <required> $class ]
      }
    }

    /**
	 * Returns collection of objects with specified data
	 * @param $class
	 * @param $data
	 * @param $params
	 * @return \Core\Collection
	 */
    Method [ <user> static protected method fillCollection ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Orm.php 269 - 287

      - Parameters [3] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <required> $data ]
        Parameter #2 [ <required> $params ]
      }
    }

    /**
	 * Saves related fields data
	 * @param Object $object
	 * @throws Exception\Exception
	 */
    Method [ <user> static private method _saveRelatedFieldsData ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 16 - 37

      - Parameters [1] {
        Parameter #0 [ <required> $object ]
      }
    }

    /**
	 * Save data to language tables, it needed for multi-language web applications
	 * @param \Core\Object $object
	 * @throws \Exception
	 */
    Method [ <user> static private method _updateLangTables ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 44 - 80

      - Parameters [1] {
        Parameter #0 [ <required> $object ]
      }
    }

    /**
	 * It prepares query for selection from language tables, if needed
	 * @param $class
	 * @param $id
	 * @return string
	 */
    Method [ <user> static protected method _makeLanguageQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 88 - 100

      - Parameters [2] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <required> $id ]
      }
    }

    /**
	 * Prepares main ORM select query
	 * @param $class
	 * @param $filters
	 * @param $values
	 * @param $params
	 * @return string
	 */
    Method [ <user> static protected method _makeSimpleQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 110 - 128

      - Parameters [4] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <required> $filters ]
        Parameter #2 [ <required> $values ]
        Parameter #3 [ <required> $params ]
      }
    }

    Method [ <user> static protected method _makeCountQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 130 - 148

      - Parameters [4] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <required> $filters ]
        Parameter #2 [ <required> $values ]
        Parameter #3 [ <optional> $params = Array ]
      }
    }

    /**
	 * Builds conditions for where and joins (if relation filters are existing)
	 * @param QueryBuilder $queryBuilder
	 * @param $filters
	 * @param $values
	 */
    Method [ <user> static protected method _buildConditions ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 156 - 188

      - Parameters [3] {
        Parameter #0 [ <required> Core\Database\QueryBuilder $queryBuilder ]
        Parameter #1 [ <required> $filters ]
        Parameter #2 [ <required> $values ]
      }
    }

    /**
	 * Builds join and where conditions for relational filters
	 * @param QueryBuilder $queryBuilder
	 * @param $field
	 * @param $index
	 * @return mixed
	 */
    Method [ <user> static protected method _buildRelationCondition ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 197 - 212

      - Parameters [3] {
        Parameter #0 [ <required> Core\Database\QueryBuilder $queryBuilder ]
        Parameter #1 [ <required> $field ]
        Parameter #2 [ <required> $index ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [0] {
  }
}
