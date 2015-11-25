Class [ <user> class Core\Library\Mail ] {
  @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Library/Mail.php 8-72

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [3] {
    Method [ <user> static public method send ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Library/Mail.php 10 - 37

      - Parameters [6] {
        Parameter #0 [ <required> $name_from ]
        Parameter #1 [ <required> $email_from ]
        Parameter #2 [ <required> $name_to ]
        Parameter #3 [ <required> $email_to ]
        Parameter #4 [ <required> $subject ]
        Parameter #5 [ <required> $body ]
      }
    }

    Method [ <user> static public method error ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Library/Mail.php 39 - 62

      - Parameters [1] {
        Parameter #0 [ <required> $text ]
      }
    }

    Method [ <user> static private method mime_header_encode ] {
      @@ /Users/vmalyshev/webserver/accounting/vendor/follower/core/backend/Library/Mail.php 64 - 71

      - Parameters [3] {
        Parameter #0 [ <required> $str ]
        Parameter #1 [ <required> $data_charset ]
        Parameter #2 [ <required> $send_charset ]
      }
    }
  }

  - Properties [0] {
  }

  - Methods [0] {
  }
}
