# Core\Database\QueryBuilder
## CONSTANTS

## PROPERTIES

#### _config
## METHODS

## __construct



	 
 Set up base table and it's alias
	 
 @param $table
	 
## select



	 
 Setups params for selections
	 
 @param $field
	 
 @param string $alias
	 
 @param string $table
	 
 @return $this
	 
## setBaseAlias



	 
 Setups base table alias
	 
 @param $alias
	 
 @return $this
	 
## join



	 
 Setups joins
	 
 @param $type
	 
 @param $table
	 
 @param $alias
	 
 @param $relations
	 
 @return $this
	 
## where



	 
 Setups where conditions
	 
 @param $value
	 
 @param $args
	 
 @param string $action
	 
 @return $this
	 
## orderBy



	 
 Setups order by conditions
	 
 @param $field
	 
 @param string $direction
	 
 @return $this
	 
## groupBy



	 
 Setups group by conditions
	 
 @param $field
	 
 @return $this
	 
## offset



	 
 Offset setup
	 
 @param $value
	 
 @return $this
	 
## limit



	 
 Limit setup
	 
 @param $value
	 
 @return $this
	 
## composeSelectQuery



	 
 Composes raw mysql query based on QueryBuilder setup
	 
 @return string
	 
## composeSelectCountQuery



	 
 Composes mysql query based on QueryBuilder setup for getting count of objects only
	 
 @return string
	 
## _composeQuery
## _composeFields



	 
 Fields composer
	 
 @return array
	 
## _composeJoins



	 
 Joins composer
	 
 @return array
	 
## _composeConditions



	 
 Conditions composer
	 
 @return array
	 
## _composerOrder



	 
 Order composer
	 
 @return string
	 
## _composeGrouping



	 
 Grouping composer
	 
 @return string
	 
## _composeLimit



	 
 Offset and limit composer
	 
 @return string
	 
## debug



	 
 Returns QueryBuilder config data
	 
 @param bool $section
	 
 @return mixed
	 
## applyAlias



	 
 Applies table/param alias
	 
 @param $value
	 
 @return mixed|string
	 
