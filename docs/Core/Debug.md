Class [ <user> class Core\Debug ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 5-172

  - Constants [0] {
  }

  - Static properties [2] {
    Property [ private static $_instance ]
    Property [ public static $phpErrorCode ]
  }

  - Static methods [1] {
    /**
	 * Returns single instance of debugger
	 * @return Debug
	 */
    Method [ <user> static public method getInstance ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 26 - 33
    }
  }

  - Properties [5] {
    Property [ <default> private $_queries ]
    Property [ <default> private $_files ]
    Property [ <default> private $_php_errors ]
    Property [ <default> private $_cms_errors ]
    Property [ <default> private $_cms_dumps ]
  }

  - Methods [10] {
    /**
	 * Logs MySQL query to debugger
	 * @param $query
	 * @param $params
	 * @param $results
	 * @param int $time
	 * @param bool $success
	 */
    Method [ <user> public method logQuery ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 43 - 68

      - Parameters [5] {
        Parameter #0 [ <required> $query ]
        Parameter #1 [ <required> $params ]
        Parameter #2 [ <required> $results ]
        Parameter #3 [ <optional> $time = 0 ]
        Parameter #4 [ <optional> $success = true ]
      }
    }

    /**
	 * Logs loaded files
	 * @param $path
	 */
    Method [ <user> public method logFile ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 74 - 77

      - Parameters [1] {
        Parameter #0 [ <required> $path ]
      }
    }

    /**
	 * Logs php errors
	 * @param $error
	 */
    Method [ <user> public method logPhpError ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 83 - 86

      - Parameters [1] {
        Parameter #0 [ <required> $error ]
      }
    }

    /**
	 * Logs framework errors
	 * @param $error
	 */
    Method [ <user> public method logCmsError ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 92 - 95

      - Parameters [1] {
        Parameter #0 [ <required> $error ]
      }
    }

    /**
	 * System::vardump logger
	 * @param $dump
	 */
    Method [ <user> public method logDump ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 101 - 111

      - Parameters [1] {
        Parameter #0 [ <required> $dump ]
      }
    }

    /**
	 * Returns logged mysql queries and its count
	 * @return array
	 */
    Method [ <user> public method getQueriesLog ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 117 - 123
    }

    /**
	 * Returns logged loaded files and its count
	 * @return array
	 */
    Method [ <user> public method getFilesLog ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 129 - 135
    }

    /**
	 * Returns logged PHP errors and its count
	 * @return array
	 */
    Method [ <user> public method getPhpErrors ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 141 - 147
    }

    /**
	 * Returns logged framework errors and its count
	 * @return array
	 */
    Method [ <user> public method getCmsErrors ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 153 - 159
    }

    /**
	 * Returns logged variable dumps and its count
	 * @return array
	 */
    Method [ <user> public method getCmsDumps ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Debug.php 165 - 171
    }
  }
}
