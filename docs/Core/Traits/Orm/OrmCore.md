# Core\Traits\Orm\OrmCore
## CONSTANTS

## PROPERTIES

## METHODS

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
	 
