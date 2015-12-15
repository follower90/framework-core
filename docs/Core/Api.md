# Core\Api
## CONSTANTS

## PROPERTIES

#### request
#### db
#### view
#### settings
## METHODS

## __construct



	 
 Assigns PDO connection to protected variable
	 
 for using in API Controllers
	 
## run



	 
 Api run wrapper for response formatting
	 
 and errors catching
	 
 @param $method
	 
 @param $args
	 
 @return array
	 
## notAuthorized



	 
 Not authorized response
	 
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
	 
