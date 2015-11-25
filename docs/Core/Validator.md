/**
 * Class Validator
 * Simple validation
 * @todo integrate to \Core\Controller for input data validation
 * @package Core
 */
Class [ <user> class Core\Validator ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Validator.php 11-100

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [3] {
    Property [ <default> private $_rules ]
    Property [ <default> private $_request ]
    Property [ <default> protected $_rulesList ]
  }

  - Methods [5] {
    /**
	 * @param $rules array, example: [ 'test' => [ 'validator' => 'text', 'message' => 'Not a text' ]];
	 * @param $request array, example: [ 'test' => 2234 ];
	 * set rules and fields to $this
	 */
    Method [ <user, ctor> public method __construct ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Validator.php 33 - 37

      - Parameters [2] {
        Parameter #0 [ <required> $rules ]
        Parameter #1 [ <required> $request ]
      }
    }

    /**
	 * Return result (success:true|false)
	 * and errors list (field => error_text), or empty array
	 * @return array
	 */
    Method [ <user> public method validate ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Validator.php 44 - 60
    }

    /**
	 * Applies validation method to the field according to the rule
	 * @param $field
	 * @param $rule
	 * @return bool
	 */
    Method [ <user> protected method _validate ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Validator.php 68 - 71

      - Parameters [2] {
        Parameter #0 [ <required> $field ]
        Parameter #1 [ <required> $rule ]
      }
    }

    /**
	 * Return false, if value is not set, or empty
	 * @param $val
	 * @return bool
	 */
    Method [ <user> private method isNotEmpty ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Validator.php 78 - 85

      - Parameters [1] {
        Parameter #0 [ <required> $val ]
      }
    }

    /**
	 * Returns false, if value is not text string
	 * @param $val
	 * @return bool
	 */
    Method [ <user> private method isText ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Validator.php 92 - 99

      - Parameters [1] {
        Parameter #0 [ <required> $val ]
      }
    }
  }
}
