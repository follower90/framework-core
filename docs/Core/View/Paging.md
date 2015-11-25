Class [ <user> class Core\View\Paging ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 9-146

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [1] {
    /**
	 * Return paging object
	 * @param $className
	 * @param array $params
	 * @return static
	 */
    Method [ <user> static public method create ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 47 - 53

      - Parameters [2] {
        Parameter #0 [ <required> $className ]
        Parameter #1 [ <optional> $params = Array ]
      }
    }
  }

  - Properties [5] {
    Property [ <default> private $_class ]
    Property [ <default> private $_curPage ]
    Property [ <default> private $_onPage ]
    Property [ <default> private $_paging ]
    Property [ <default> private $_collection ]
  }

  - Methods [9] {
    Method [ <user, ctor> private method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 34 - 39

      - Parameters [3] {
        Parameter #0 [ <required> $className ]
        Parameter #1 [ <required> $currentPage ]
        Parameter #2 [ <required> $onPage ]
      }
    }

    /**
	 * Requests objects from database
	 * Calculates limit, offset, count
	 */
    Method [ <user> private method _calculate ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 59 - 76
    }

    /**
	 * Creates new view with paging data
	 * @return string rendered paging template
	 */
    Method [ <user> public method getPaging ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 82 - 89
    }

    /**
	 * Checks if collection requires paginating
	 * @return bool
	 */
    Method [ <user> public method needsPaging ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 95 - 98
    }

    /**
	 * Returns number of first item on the page
	 * @return int
	 */
    Method [ <user> public method firstItemOnPage ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 104 - 108
    }

    /**
	 * Returns number of last item on the page
	 * @return int
	 */
    Method [ <user> public method lastItemOnPage ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 114 - 117
    }

    /**
	 * Returns true if the page is first
	 * @return bool
	 */
    Method [ <user> public method isFirstPage ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 123 - 126
    }

    /**
	 * Returns true if the page is last
	 * @return bool
	 */
    Method [ <user> public method isLastPage ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 132 - 135
    }

    /**
	 * Returns array of fetched objects from database
	 * required for concrete page
	 * @return array
	 */
    Method [ <user> public method getObjects ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/View/Paging.php 142 - 145
    }
  }
}
