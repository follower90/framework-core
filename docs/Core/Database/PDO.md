Class [ <user> class Core\Database\PDO extends PDO ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 8-236

  - Constants [84] {
    Constant [ integer PARAM_BOOL ] { 5 }
    Constant [ integer PARAM_NULL ] { 0 }
    Constant [ integer PARAM_INT ] { 1 }
    Constant [ integer PARAM_STR ] { 2 }
    Constant [ integer PARAM_LOB ] { 3 }
    Constant [ integer PARAM_STMT ] { 4 }
    Constant [ integer PARAM_INPUT_OUTPUT ] { 2147483648 }
    Constant [ integer PARAM_EVT_ALLOC ] { 0 }
    Constant [ integer PARAM_EVT_FREE ] { 1 }
    Constant [ integer PARAM_EVT_EXEC_PRE ] { 2 }
    Constant [ integer PARAM_EVT_EXEC_POST ] { 3 }
    Constant [ integer PARAM_EVT_FETCH_PRE ] { 4 }
    Constant [ integer PARAM_EVT_FETCH_POST ] { 5 }
    Constant [ integer PARAM_EVT_NORMALIZE ] { 6 }
    Constant [ integer FETCH_LAZY ] { 1 }
    Constant [ integer FETCH_ASSOC ] { 2 }
    Constant [ integer FETCH_NUM ] { 3 }
    Constant [ integer FETCH_BOTH ] { 4 }
    Constant [ integer FETCH_OBJ ] { 5 }
    Constant [ integer FETCH_BOUND ] { 6 }
    Constant [ integer FETCH_COLUMN ] { 7 }
    Constant [ integer FETCH_CLASS ] { 8 }
    Constant [ integer FETCH_INTO ] { 9 }
    Constant [ integer FETCH_FUNC ] { 10 }
    Constant [ integer FETCH_GROUP ] { 65536 }
    Constant [ integer FETCH_UNIQUE ] { 196608 }
    Constant [ integer FETCH_KEY_PAIR ] { 12 }
    Constant [ integer FETCH_CLASSTYPE ] { 262144 }
    Constant [ integer FETCH_SERIALIZE ] { 524288 }
    Constant [ integer FETCH_PROPS_LATE ] { 1048576 }
    Constant [ integer FETCH_NAMED ] { 11 }
    Constant [ integer ATTR_AUTOCOMMIT ] { 0 }
    Constant [ integer ATTR_PREFETCH ] { 1 }
    Constant [ integer ATTR_TIMEOUT ] { 2 }
    Constant [ integer ATTR_ERRMODE ] { 3 }
    Constant [ integer ATTR_SERVER_VERSION ] { 4 }
    Constant [ integer ATTR_CLIENT_VERSION ] { 5 }
    Constant [ integer ATTR_SERVER_INFO ] { 6 }
    Constant [ integer ATTR_CONNECTION_STATUS ] { 7 }
    Constant [ integer ATTR_CASE ] { 8 }
    Constant [ integer ATTR_CURSOR_NAME ] { 9 }
    Constant [ integer ATTR_CURSOR ] { 10 }
    Constant [ integer ATTR_ORACLE_NULLS ] { 11 }
    Constant [ integer ATTR_PERSISTENT ] { 12 }
    Constant [ integer ATTR_STATEMENT_CLASS ] { 13 }
    Constant [ integer ATTR_FETCH_TABLE_NAMES ] { 14 }
    Constant [ integer ATTR_FETCH_CATALOG_NAMES ] { 15 }
    Constant [ integer ATTR_DRIVER_NAME ] { 16 }
    Constant [ integer ATTR_STRINGIFY_FETCHES ] { 17 }
    Constant [ integer ATTR_MAX_COLUMN_LEN ] { 18 }
    Constant [ integer ATTR_EMULATE_PREPARES ] { 20 }
    Constant [ integer ATTR_DEFAULT_FETCH_MODE ] { 19 }
    Constant [ integer ERRMODE_SILENT ] { 0 }
    Constant [ integer ERRMODE_WARNING ] { 1 }
    Constant [ integer ERRMODE_EXCEPTION ] { 2 }
    Constant [ integer CASE_NATURAL ] { 0 }
    Constant [ integer CASE_LOWER ] { 2 }
    Constant [ integer CASE_UPPER ] { 1 }
    Constant [ integer NULL_NATURAL ] { 0 }
    Constant [ integer NULL_EMPTY_STRING ] { 1 }
    Constant [ integer NULL_TO_STRING ] { 2 }
    Constant [ string ERR_NONE ] { 00000 }
    Constant [ integer FETCH_ORI_NEXT ] { 0 }
    Constant [ integer FETCH_ORI_PRIOR ] { 1 }
    Constant [ integer FETCH_ORI_FIRST ] { 2 }
    Constant [ integer FETCH_ORI_LAST ] { 3 }
    Constant [ integer FETCH_ORI_ABS ] { 4 }
    Constant [ integer FETCH_ORI_REL ] { 5 }
    Constant [ integer CURSOR_FWDONLY ] { 0 }
    Constant [ integer CURSOR_SCROLL ] { 1 }
    Constant [ integer MYSQL_ATTR_USE_BUFFERED_QUERY ] { 1000 }
    Constant [ integer MYSQL_ATTR_LOCAL_INFILE ] { 1001 }
    Constant [ integer MYSQL_ATTR_INIT_COMMAND ] { 1002 }
    Constant [ integer MYSQL_ATTR_COMPRESS ] { 1003 }
    Constant [ integer MYSQL_ATTR_DIRECT_QUERY ] { 1004 }
    Constant [ integer MYSQL_ATTR_FOUND_ROWS ] { 1005 }
    Constant [ integer MYSQL_ATTR_IGNORE_SPACE ] { 1006 }
    Constant [ integer MYSQL_ATTR_SSL_KEY ] { 1007 }
    Constant [ integer MYSQL_ATTR_SSL_CERT ] { 1008 }
    Constant [ integer MYSQL_ATTR_SSL_CA ] { 1009 }
    Constant [ integer MYSQL_ATTR_SSL_CAPATH ] { 1010 }
    Constant [ integer MYSQL_ATTR_SSL_CIPHER ] { 1011 }
    Constant [ integer MYSQL_ATTR_SERVER_PUBLIC_KEY ] { 1012 }
    Constant [ integer MYSQL_ATTR_MULTI_STATEMENTS ] { 1013 }
  }

  - Static properties [2] {
    Property [ private static $_instance ]
    Property [ private static $_debugger ]
  }

  - Static methods [2] {
    /**
	 * Return single instance of PDO connection
	 * @return PDO
	 */
    Method [ <user> static public method getInstance ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 59 - 71
    }

    Method [ <internal:PDO, inherits PDO> static public method getAvailableDrivers ] {

      - Parameters [0] {
      }
    }
  }

  - Properties [5] {
    Property [ <default> private $_pattern ]
    Property [ <default> private $_vars ]
    Property [ <default> private $_result ]
    Property [ <default> private $_start ]
    Property [ <default> private $_sth ]
  }

  - Methods [25] {
    /**
	 * Constructs new Mysql connection with PDO
	 * @param $settings
	 */
    Method [ <user, overwrites PDO, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 23 - 53

      - Parameters [1] {
        Parameter #0 [ <required> $settings ]
      }
    }

    /**
	 * Executes query
	 * @param string $pattern
	 * @param null $vars
	 * @return bool
	 */
    Method [ <user, overwrites PDO, prototype PDO> public method query ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 79 - 89

      - Parameters [2] {
        Parameter #0 [ <required> $pattern ]
        Parameter #1 [ <optional> $vars = NULL ]
      }
    }

    /**
	 * Insert query, returns inserted id
	 * @param $pattern
	 * @param null $vars
	 * @return bool|string
	 */
    Method [ <user> public method insert_id ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 97 - 107

      - Parameters [2] {
        Parameter #0 [ <required> $pattern ]
        Parameter #1 [ <optional> $vars = NULL ]
      }
    }

    /**
	 * Selects multiple rows and return associative array
	 * @param $pattern
	 * @param null $vars
	 * @return bool
	 */
    Method [ <user> public method rows ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 115 - 125

      - Parameters [2] {
        Parameter #0 [ <required> $pattern ]
        Parameter #1 [ <optional> $vars = NULL ]
      }
    }

    /**
	 * Select single row and return associative array
	 * @param $pattern
	 * @param null $vars
	 * @return bool
	 */
    Method [ <user> public method row ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 133 - 143

      - Parameters [2] {
        Parameter #0 [ <required> $pattern ]
        Parameter #1 [ <optional> $vars = NULL ]
      }
    }

    /**
	 * Selects single value
	 * @param $pattern
	 * @param null $vars
	 * @return bool
	 */
    Method [ <user> public method cell ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 151 - 161

      - Parameters [2] {
        Parameter #0 [ <required> $pattern ]
        Parameter #1 [ <optional> $vars = NULL ]
      }
    }

    /**
	 * Selects and return key->value array by first two selected cells
	 * @param $pattern
	 * @param null $vars
	 * @return bool
	 */
    Method [ <user> public method rows_key ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 169 - 179

      - Parameters [2] {
        Parameter #0 [ <required> $pattern ]
        Parameter #1 [ <optional> $vars = NULL ]
      }
    }

    /**
	 * Executes every Mysql query
	 * @param $pattern
	 * @param $vars
	 * @return bool
	 */
    Method [ <user> private method _executeQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 187 - 196

      - Parameters [2] {
        Parameter #0 [ <required> $pattern ]
        Parameter #1 [ <required> $vars ]
      }
    }

    /**
	 * Writes query start microtime and executes query
	 * @param $pattern
	 * @param $vars
	 */
    Method [ <user> private method _prepareQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 203 - 210

      - Parameters [2] {
        Parameter #0 [ <required> $pattern ]
        Parameter #1 [ <required> $vars ]
      }
    }

    /**
	 * Write failed queries to debugger
	 * @return bool
	 */
    Method [ <user> private method _logError ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 216 - 220
    }

    /**
	 * Writes successful queries to debugger
	 */
    Method [ <user> private method _logQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Database/PDO.php 225 - 235
    }

    Method [ <internal:PDO, inherits PDO> public method prepare ] {

      - Parameters [2] {
        Parameter #0 [ <required> $statement ]
        Parameter #1 [ <optional> $options ]
      }
    }

    Method [ <internal:PDO, inherits PDO> public method beginTransaction ] {

      - Parameters [0] {
      }
    }

    Method [ <internal:PDO, inherits PDO> public method commit ] {

      - Parameters [0] {
      }
    }

    Method [ <internal:PDO, inherits PDO> public method rollBack ] {

      - Parameters [0] {
      }
    }

    Method [ <internal:PDO, inherits PDO> public method inTransaction ] {

      - Parameters [0] {
      }
    }

    Method [ <internal:PDO, inherits PDO> public method setAttribute ] {

      - Parameters [2] {
        Parameter #0 [ <required> $attribute ]
        Parameter #1 [ <required> $value ]
      }
    }

    Method [ <internal:PDO, inherits PDO> public method exec ] {

      - Parameters [1] {
        Parameter #0 [ <required> $query ]
      }
    }

    Method [ <internal:PDO, inherits PDO> public method lastInsertId ] {

      - Parameters [1] {
        Parameter #0 [ <optional> $seqname ]
      }
    }

    Method [ <internal:PDO, inherits PDO> public method errorCode ] {

      - Parameters [0] {
      }
    }

    Method [ <internal:PDO, inherits PDO> public method errorInfo ] {

      - Parameters [0] {
      }
    }

    Method [ <internal:PDO, inherits PDO> public method getAttribute ] {

      - Parameters [1] {
        Parameter #0 [ <required> $attribute ]
      }
    }

    Method [ <internal:PDO, inherits PDO> public method quote ] {

      - Parameters [2] {
        Parameter #0 [ <required> $string ]
        Parameter #1 [ <optional> $paramtype ]
      }
    }

    Method [ <internal:PDO, inherits PDO> final public method __wakeup ] {

      - Parameters [0] {
      }
    }

    Method [ <internal:PDO, inherits PDO> final public method __sleep ] {

      - Parameters [0] {
      }
    }
  }
}
