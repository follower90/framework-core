# Core\EntryPoint
## CONSTANTS

## PROPERTIES

#### _lib
## METHODS

## init



	 
 Abstract init method
	 
 Must be defined in project entry points
	 
 @return mixed
	 
## output



	 
 Default output method
	 
 Can be overridden with any data transformation
	 
 @param $data
	 
 @return mixed
	 
## getLib



	 
 Return namespace name. Must to have been set at first
	 
 @return mixed
	 
 @throws \Exception
	 
## setLib



	 
 Set method for setting project namespace
	 
 @param $path
	 
## request



	 
 Returns POST and GET params merged together
	 
 @param bool $key
	 
 @return array|bool
	 
## debug



	 
 Allows debug mode
	 
 Can be overridden in site entry points
	 
 @return bool
	 
