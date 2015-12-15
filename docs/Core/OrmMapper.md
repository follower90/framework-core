# Core\OrmMapper
## CONSTANTS

## PROPERTIES

#### _collection
#### _object
#### _fields
#### _filters
#### _offset
#### _sorting
#### _limit
#### _map
#### _allowedFields
## METHODS

## __construct



	 
 Private constructor
	 
 Sets class and gets object configs
	 
 @param $class
	 
## create



	 
 Creates new OrmMapper
	 
 @param $class
	 
 @return \Core\OrmMapper
	 
 @throws \Exception
	 
## viewConfig



	 
 Shows config by alias
	 
 @param $alias string
	 
 @return array 
	 
## getCollection



	 
 Returns object collection
	 
 @return \Core\Collection
	 
## setFields



	 
 Sets fields for getting
	 
 @todo fix for getting related fields
	 
 @param $fields
	 
 @return \Core\OrmMapper
	 
## setSorting



	 
 Set ordering
	 
 @param $field
	 
 @param string $sort
	 
 @return \Core\OrmMapper
	 
## setFilter



	 
 Set filter conditions
	 
 @param $keys
	 
 @param $values
	 
 @return \Core\OrmMapper
	 
## addFilter



	 
 Add single filter conditions
	 
 @param $key
	 
 @param $value
	 
 @return \Core\OrmMapper
	 
## setOffset



	 
 Set offset
	 
 @param $offset
	 
 @return \Core\OrmMapper
	 
## setLimit



	 
 Set limit
	 
 @param $limit
	 
 @return \Core\OrmMapper
	 
## load



	 
 Load mapper with set params
	 
 @return \Core\Collection
	 
## getDataMap



	 
 Returns simple array values map
	 
 @return array
	 
 @throws \Exception
	 
## getRelatedMapper



	 
 Get related mapper by object relation
	 
 @param $alias
	 
 @return bool|OrmMapper
	 
