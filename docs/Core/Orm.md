# Core\Orm
## CONSTANTS

## PROPERTIES

#### _object
#### _cache
## METHODS

## create



	 
 Creates and returns new Object
	 
 @param $class
	 
 @return \Core\Object
	 
## save



	 
 Saves object to database
	 
 @param \Core\Object $object
	 
 @return bool
	 
 @throws \Exception
	 
## find



	 
 Load objects collection from database
	 
 @param $class
	 
 @param array $filters
	 
 @param array $values
	 
 @param array $params
	 
 @return bool|\Core\Collection
	 
## count



	 
 Returns count of requested object
	 
 @param $class
	 
 @param array $filters
	 
 @param array $values
	 
 @return int
	 
## findOne



	 
 Find first object by given parameters
	 
 @param $class
	 
 @param array $filters
	 
 @param array $values
	 
 @return \Core\Object
	 
## load



	 
 Load object by its id
	 
 @param $class
	 
 @param $id
	 
 @return \Core\Object or false
	 
## delete



	 
 Deletes object from database
	 
 @param \Core\Object $object
	 
 @return bool
	 
 @throws \Exception
	 
## clearCache



	 
 Cleans orm cache
	 
## getOrmCache



	 
 returns or creates single Cache object
	 
 @return OrmCache
	 
## registerRelation



	 
 @param [type, alias, ...] $relationProperties
	 
 @param $targetObjectProperties
	 
 @param $relatedObjectProperties
	 
 @throws \Exception if target object is illegal
	 
## detectClass



	 
 Returns full class name with namespaces from registered projects by given object name
	 
 @param $class
	 
 @return string
	 
 @throws \Exception
	 
## _getObject



	 
 Returns new object by requested class name
	 
 @param $class string object name
	 
 @return \Core\Object
	 
 @throws \Exception in detectClass method
	 
## fillCollection



	 
 Returns collection of objects with specified data
	 
 @param $class
	 
 @param $data
	 
 @param $params
	 
 @return \Core\Collection
	 
## _saveRelatedFieldsData



	 
 Saves related fields data
	 
 @param Object $object
	 
 @throws Exception\Exception
	 
## _updateLangTables



	 
 Save data to language tables, it needed for multi-language web applications
	 
 @param \Core\Object $object
	 
 @throws \Exception
	 
## _makeLanguageQuery



	 
 It prepares query for selection from language tables, if needed
	 
 @param $class
	 
 @param $id
	 
 @return string
	 
## _makeSimpleQuery



	 
 Prepares main ORM select query
	 
 @param $class
	 
 @param $filters
	 
 @param $values
	 
 @param $params
	 
 @return string
	 
## _makeCountQuery
## _buildConditions



	 
 Builds conditions for where and joins (if relation filters are existing)
	 
 @param QueryBuilder $queryBuilder
	 
 @param $filters
	 
 @param $values
	 
## _buildRelationCondition



	 
 Builds join and where conditions for relational filters
	 
 @param QueryBuilder $queryBuilder
	 
 @param $field
	 
 @param $index
	 
 @return mixed
	 
