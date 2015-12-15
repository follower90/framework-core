# Core\Traits\Object\ActiveRecord
## CONSTANTS

## PROPERTIES

## METHODS

## all



	 
 Returns orm mapper for object
	 
 @return OrmMapper
	 
## create



	 
 Returns new user object
	 
 @return Object
	 
## save



	 
 Syntax sugar, just saves object with Orm
	 
 @throws \Exception
	 
## delete



	 
 Syntax sugar, just deletes object with Orm
	 
 @throws \Exception
	 
## find



	 
 ActiveRecord-like syntax sugar
	 
 @param int $id
	 
 @return bool|\Core\Object
	 
## findBy



	 
 ActiveRecord-like syntax sugar
	 
 @param $params
	 
 @return bool|Collection
	 
## where



	 
 ActiveRecord-like syntax sugar
	 
 @param $params
	 
 @return bool|Collection
	 
## __set



	 
 Syntax sugar method
	 
 Sets arguments using magic method
	 
 for use setValue method like direct property
	 
 @param attr
	 
 @param value
	 
## __get



	 
 Syntax sugar method
	 
 Returns value using magic method
	 
 for use getValue method like direct property
	 
 @param attr
	 
 @return OrmMapper
	 
