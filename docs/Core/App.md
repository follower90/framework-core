/**
 * Class App
 * Main application class
 * It sets user, entry point, requests router params, debug mode, error handlers
 * and launches controller
 *
 * @package Core
 */
Class [ <user> class Core\App ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 13-269

  - Constants [0] {
  }

  - Static properties [2] {
    Property [ private static $_user ]
    Property [ private static $_instance ]
  }

  - Static methods [3] {
    /**
	 * Returns App instance
	 */
    Method [ <user> static public method get ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 72 - 79
    }

    /**
	 * Sets authorized user globally
	 *
	 * @param \Core\Object $user
	 */
    Method [ <user> static public method setUser ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 133 - 136

      - Parameters [1] {
        Parameter #0 [ <required> Core\Object $user ]
      }
    }

    /**
	 * Get authorized user object
	 * @return bool|\Core\Object
	 */
    Method [ <user> static public method getUser ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 171 - 174
    }
  }

  - Properties [4] {
    Property [ <default> private $_entryPoint ]
    Property [ <default> private $_debugParam ]
    Property [ <default> private $_vendorPath ]
    Property [ <default> private $_appPath ]
  }

  - Methods [10] {
    /**
	 * Sets application root path
	 * and entry point
	 *
	 * @param EntryPoint $entryPoint
	 */
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 57 - 67

      - Parameters [1] {
        Parameter #0 [ <required> Core\EntryPoint $entryPoint ]
      }
    }

    /**
	 * Show debugger console
	 * in the end of application life cycle
	 */
    Method [ <user, dtor> public method __destruct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 85 - 90
    }

    /**
	 * Core application run method
	 * Setups debugger, file including and error handling
	 * Requests route and calls API/Controller
	 *
	 * @throws \Exception
	 */
    Method [ <user> public method run ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 99 - 126
    }

    /**
	 * Get root path of vendor in current entry point
	 * @param string $path
	 * @return true
	 */
    Method [ <user> public method setVendorPath ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 143 - 147

      - Parameters [1] {
        Parameter #0 [ <required> $path ]
      }
    }

    /**
	 * Get root path of vendor in current entry point
	 * @return string path
	 */
    Method [ <user> public method getVendorPath ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 153 - 156
    }

    /**
	 * Get root path of application at server
	 * @return string
	 */
    Method [ <user> public method getAppPath ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 162 - 165
    }

    /**
	 * Setups debug-mode cookie
	 * based on GET param
	 */
    Method [ <user> private method _setupDebugMode ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 180 - 194
    }

    /**
	 * Gets debugger instance, gets all logged data
	 * and renders template with debug console
	 *
	 * @param string $debug on/off
	 * @todo refactor for allowed IPs configuration
	 */
    Method [ <user> public method showDebugConsole ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 203 - 224

      - Parameters [1] {
        Parameter #0 [ <optional> $debug = 'on' ]
      }
    }

    /**
	 * Registering handler function for
	 * logging included files into debugger
	 */
    Method [ <user> private method _setFileIncludeHandler ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 230 - 236
    }

    /**
	 * Logs PHP warnings, notices and fatal errors to debug console
	 * Shows debug console immediately in case of fatal error
	 */
    Method [ <user> private method _setErrorHandlers ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/App.php 242 - 268
    }
  }
}
