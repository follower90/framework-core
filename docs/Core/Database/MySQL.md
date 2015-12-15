# Core\Database\MySQL
## CONSTANTS

## PROPERTIES

## METHODS

## update



	 
 Runs Mysql update query
	 
 @param $table
	 
 @param array $params
	 
 @param array $conditions
	 
 @throws \Exception
	 
## insert



	 
 Runs Mysql insert query
	 
 @param $table
	 
 @param array $params
	 
 @return int $insertId
	 
 @throws \Exception
	 
## delete



	 
 Deletes from table with specified conditions
	 
 @param $table
	 
 @param array $conditions
	 
 @throws \Exception
	 
## query



	 
 Runs RAW Mysql query without any conversions
	 
 @param $query
	 
 @return int success
	 
## row



	 
 Runs RAW Mysql query without any conversions
	 
 @param $query
	 
 @return Array result of query
	 
