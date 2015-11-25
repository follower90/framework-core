Trait [ <user> trait Core\Traits\View\Html ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Traits/View/Html.php 5-63

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [0] {
  }

  - Methods [4] {
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
