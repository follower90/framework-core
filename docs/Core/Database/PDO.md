# Core\Database\PDO
## CONSTANTS

#### PARAM_BOOL
#### PARAM_NULL
#### PARAM_INT
#### PARAM_STR
#### PARAM_LOB
#### PARAM_STMT
#### PARAM_INPUT_OUTPUT
#### PARAM_EVT_ALLOC
#### PARAM_EVT_FREE
#### PARAM_EVT_EXEC_PRE
#### PARAM_EVT_EXEC_POST
#### PARAM_EVT_FETCH_PRE
#### PARAM_EVT_FETCH_POST
#### PARAM_EVT_NORMALIZE
#### FETCH_LAZY
#### FETCH_ASSOC
#### FETCH_NUM
#### FETCH_BOTH
#### FETCH_OBJ
#### FETCH_BOUND
#### FETCH_COLUMN
#### FETCH_CLASS
#### FETCH_INTO
#### FETCH_FUNC
#### FETCH_GROUP
#### FETCH_UNIQUE
#### FETCH_KEY_PAIR
#### FETCH_CLASSTYPE
#### FETCH_SERIALIZE
#### FETCH_PROPS_LATE
#### FETCH_NAMED
#### ATTR_AUTOCOMMIT
#### ATTR_PREFETCH
#### ATTR_TIMEOUT
#### ATTR_ERRMODE
#### ATTR_SERVER_VERSION
#### ATTR_CLIENT_VERSION
#### ATTR_SERVER_INFO
#### ATTR_CONNECTION_STATUS
#### ATTR_CASE
#### ATTR_CURSOR_NAME
#### ATTR_CURSOR
#### ATTR_ORACLE_NULLS
#### ATTR_PERSISTENT
#### ATTR_STATEMENT_CLASS
#### ATTR_FETCH_TABLE_NAMES
#### ATTR_FETCH_CATALOG_NAMES
#### ATTR_DRIVER_NAME
#### ATTR_STRINGIFY_FETCHES
#### ATTR_MAX_COLUMN_LEN
#### ATTR_EMULATE_PREPARES
#### ATTR_DEFAULT_FETCH_MODE
#### ERRMODE_SILENT
#### ERRMODE_WARNING
#### ERRMODE_EXCEPTION
#### CASE_NATURAL
#### CASE_LOWER
#### CASE_UPPER
#### NULL_NATURAL
#### NULL_EMPTY_STRING
#### NULL_TO_STRING
#### ERR_NONE
#### FETCH_ORI_NEXT
#### FETCH_ORI_PRIOR
#### FETCH_ORI_FIRST
#### FETCH_ORI_LAST
#### FETCH_ORI_ABS
#### FETCH_ORI_REL
#### CURSOR_FWDONLY
#### CURSOR_SCROLL
#### MYSQL_ATTR_USE_BUFFERED_QUERY
#### MYSQL_ATTR_LOCAL_INFILE
#### MYSQL_ATTR_INIT_COMMAND
#### MYSQL_ATTR_COMPRESS
#### MYSQL_ATTR_DIRECT_QUERY
#### MYSQL_ATTR_FOUND_ROWS
#### MYSQL_ATTR_IGNORE_SPACE
#### MYSQL_ATTR_SSL_KEY
#### MYSQL_ATTR_SSL_CERT
#### MYSQL_ATTR_SSL_CA
#### MYSQL_ATTR_SSL_CAPATH
#### MYSQL_ATTR_SSL_CIPHER
#### MYSQL_ATTR_SERVER_PUBLIC_KEY
#### MYSQL_ATTR_MULTI_STATEMENTS
#### ODBC_ATTR_USE_CURSOR_LIBRARY
#### ODBC_ATTR_ASSUME_UTF8
#### ODBC_SQL_USE_IF_NEEDED
#### ODBC_SQL_USE_DRIVER
#### ODBC_SQL_USE_ODBC
## PROPERTIES

#### _instance
#### _debugger
#### _pattern
#### _vars
#### _result
#### _start
#### _sth
## METHODS

## __construct



	 
 Constructs new Mysql connection with PDO
	 
 @param $settings
	 
## getInstance



	 
 Return single instance of PDO connection
	 
 @return PDO
	 
## query



	 
 Executes query
	 
 @param string $pattern
	 
 @param null $vars
	 
 @return bool
	 
## insert_id



	 
 Insert query, returns inserted id
	 
 @param $pattern
	 
 @param null $vars
	 
 @return bool|string
	 
## rows



	 
 Selects multiple rows and return associative array
	 
 @param $pattern
	 
 @param null $vars
	 
 @return bool
	 
## row



	 
 Select single row and return associative array
	 
 @param $pattern
	 
 @param null $vars
	 
 @return bool
	 
## cell



	 
 Selects single value
	 
 @param $pattern
	 
 @param null $vars
	 
 @return bool
	 
## rows_key



	 
 Selects and return key->value array by first two selected cells
	 
 @param $pattern
	 
 @param null $vars
	 
 @return bool
	 
## _executeQuery



	 
 Executes every Mysql query
	 
 @param $pattern
	 
 @param $vars
	 
 @return bool
	 
## _prepareQuery



	 
 Writes query start microtime and executes query
	 
 @param $pattern
	 
 @param $vars
	 
## _logError



	 
 Write failed queries to debugger
	 
 @return bool
	 
## _logQuery



	 
 Writes successful queries to debugger
	 
## prepare
## beginTransaction
## commit
## rollBack
## inTransaction
## setAttribute
## exec
## lastInsertId
## errorCode
## errorInfo
## getAttribute
## quote
## __wakeup
## __sleep
## getAvailableDrivers
