# Core\Debug
## CONSTANTS

## PROPERTIES

#### _instance
#### _queries
#### _files
#### _php_errors
#### _framework_errors
#### _dumps
#### phpErrorCode
## METHODS

## getInstance



	 
 Returns single instance of debugger
	 
 @return Debug
	 
## logQuery



	 
 Logs MySQL query to debugger
	 
 @param $query
	 
 @param $params
	 
 @param $results
	 
 @param int $time
	 
 @param bool $success
	 
## logFile



	 
 Logs loaded files
	 
 @param $path
	 
## logPhpError



	 
 Logs php errors
	 
 @param $error
	 
## logFrameworkError



	 
 Logs framework errors
	 
 @param $error
	 
## logDump



	 
 System::vardump logger
	 
 @param $dump
	 
## getQueriesLog



	 
 Returns logged mysql queries and its count
	 
 @return array
	 
## getFilesLog



	 
 Returns logged loaded files and its count
	 
 @return array
	 
## getPhpErrors



	 
 Returns logged PHP errors and its count
	 
 @return array
	 
## getFrameworkErrors



	 
 Returns logged framework errors and its count
	 
 @return array
	 
## getDumps



	 
 Returns logged variable dumps and its count
	 
 @return array
	 
## _processQueryParam
