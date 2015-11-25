Class [ <user> class Core\View ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 4-174

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [1] {
    /**
	 * Renders string with vars replacement
	 * @param string $string
	 * @param array $vars
	 * @return string
	 */
    Method [ <user> static public method renderString ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 92 - 100

      - Parameters [2] {
        Parameter #0 [ <required> $string ]
        Parameter #1 [ <optional> $vars = Array ]
      }
    }
  }

  - Properties [6] {
    Property [ <default> private $_templateOptions ]
    Property [ <default> private $_defaultPath ]
    Property [ <default> private $_styles ]
    Property [ <default> private $_scripts ]
    Property [ <default> private $_noticeObject ]
    Property [ <default> private $_notices ]
  }

  - Methods [15] {
    /**
	 * Template params setter
	 * @param $data
	 */
    Method [ <user> public method setOptions ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 21 - 24

      - Parameters [1] {
        Parameter #0 [ <required> $data ]
      }
    }

    /**
	 * Single template param setter
	 * @param $key
	 * @param $value
	 */
    Method [ <user> public method setOption ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 31 - 34

      - Parameters [2] {
        Parameter #0 [ <required> $key ]
        Parameter #1 [ <required> $value ]
      }
    }

    /**
	 * Return resources batch by type
	 * @param string $type
	 */
    Method [ <user> public method loadResources ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 40 - 54

      - Parameters [1] {
        Parameter #0 [ <optional> $type = false ]
      }
    }

    /**
	 * Renders template with vars
	 * @param $tpl
	 * @param array $vars (do not rename it!)
	 * @return string
	 */
    Method [ <user> public method render ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 62 - 84

      - Parameters [2] {
        Parameter #0 [ <required> $tpl ]
        Parameter #1 [ <optional> $vars = Array ]
      }
    }

    /**
	 * Set path to folder with templates, etc.
	 * @param $path string to public folder
	 */
    Method [ <user> public method setDefaultPath ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 106 - 109

      - Parameters [1] {
        Parameter #0 [ <required> $path ]
      }
    }

    /**
	 * Includes css/js/etc. file into template
	 * Root path is "vendor path" for current entry point
	 * Look into Html trait for setup concrete loading methods
	 * @param $type
	 * @param string $vars
	 * @return string
	 */
    Method [ <user> public method load ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 119 - 126

      - Parameters [2] {
        Parameter #0 [ <required> $type ]
        Parameter #1 [ <required> $path ]
      }
    }

    /**
	 * Prepares multiple resources
	 * @param $type
	 * @param array $paths
	 * @return string
	 */
    Method [ <user> private method _prepare ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 134 - 142

      - Parameters [2] {
        Parameter #0 [ <required> $type ]
        Parameter #1 [ <optional> $paths = Array ]
      }
    }

    Method [ <user> public method setNoticeObject ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 144 - 147

      - Parameters [1] {
        Parameter #0 [ <required> $name ]
      }
    }

    Method [ <user> public method addNotice ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 149 - 155

      - Parameters [2] {
        Parameter #0 [ <required> $type ]
        Parameter #1 [ <required> $text ]
      }
    }

    Method [ <user> public method getNotices ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 157 - 163
    }

    Method [ <user> public method renderNotices ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View.php 165 - 173

      - Parameters [1] {
        Parameter #0 [ <required> $data ]
      }
    }

    /**
	 * Renders select box
	 * @param $optionsMap - requires key value params map
	 * @param array $params - associative array, id, class, name
	 * @param array $default - default key
	 * @return string
	 */
    Method [ <user> public method select ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/View/Html.php 14 - 34

      - Parameters [3] {
        Parameter #0 [ <required> $optionsMap ]
        Parameter #1 [ <optional> $params = Array ]
        Parameter #2 [ <optional> $default = Array ]
      }
    }

    /**
	 * Generates style including link
	 * @return string
	 */
    Method [ <user> public method loadCss ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/View/Html.php 40 - 43

      - Parameters [1] {
        Parameter #0 [ <required> $path ]
      }
    }

    /**
	 * Generates javascript including link
	 * @return string
	 */
    Method [ <user> public method loadJs ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/View/Html.php 49 - 52

      - Parameters [1] {
        Parameter #0 [ <required> $path ]
      }
    }

    /**
	 * Generates javascript including link
	 * @return string
	 */
    Method [ <user> public method loadPhtml ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/View/Html.php 58 - 62

      - Parameters [1] {
        Parameter #0 [ <required> $path ]
      }
    }
  }
}
