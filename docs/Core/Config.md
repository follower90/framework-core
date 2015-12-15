# Core\Config
## CONSTANTS

## PROPERTIES

#### config
## METHODS

## dbConnection



	 
 Get default database connection
	 
 @todo refactor for use different connections with different projects / objects
	 
 @return mixed
	 
## tplSettings



	 
 Set path to templates folder
	 
 @todo refactor for using with multiple projects and templates folders location
	 
 @return mixed
	 
## get



	 
 Get config param by key, or get whole config array
	 
 @param $item
	 
 @return array
	 
## registerProject



	 
 Register project with its namespace
	 
 @param $project
	 
 @param $connection
	 
## setDb



	 
 Set database connection params
	 
 @param $alias
	 
 @param $config
	 
## set



	 
 Set custom property to Config
	 
 @param $item
	 
 @param $value
	 
