Trait [ <user> trait Core\Traits\Orm\OrmCore ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 9-214

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [7] {
    /**
	 * Saves related fields data
	 * @param Object $object
	 * @throws Exception\Exception
	 */
    Method [ <user> static private method _saveRelatedFieldsData ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 17 - 38

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
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 45 - 81

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
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 89 - 101

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
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 111 - 129

      - Parameters [4] {
        Parameter #0 [ <required> $class ]
        Parameter #1 [ <required> $filters ]
        Parameter #2 [ <required> $values ]
        Parameter #3 [ <required> $params ]
      }
    }

    Method [ <user> static protected method _makeCountQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 131 - 149

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
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 157 - 189

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
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/Orm/OrmCore.php 198 - 213

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
