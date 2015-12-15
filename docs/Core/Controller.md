# Core\Controller
## CONSTANTS

## PROPERTIES

#### db
#### view
#### settings
## METHODS

## __construct



	 
 Assigns PDO Mysql connection to protected variable
	 
 Assigns View object for templates rendering
	 
## run



	 
 Controllers run wrapper
	 
 for error catching
	 
 @param $method
	 
 @param $args
	 
 @return mixed
	 
## request



	 
 Helper method for get POST and GET request variables
	 
 @param bool $key
	 
 @return array|bool
	 
## execute



	 
 Api/Controller method executor
	 
 For running one controller's method from another and avoid code duplication
	 
 @param $apiPath
	 
 @param $arguments
	 
 @return mixed
	 
 @throws \Exception
	 
