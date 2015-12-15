# Core\Database\Schema
## CONSTANTS

## PROPERTIES

#### _object
#### _table
#### _fields
## METHODS

## __construct



	 
 Setups object table and fields
	 
 @param \Core\Object $object
	 
## createObjects



	 
 Process launch method, setups for wiping database
	 
 @param array $path
	 
 @param array $params
	 
## createObject



	 
 Creates table by object name
	 
 @param array $name
	 
 @param array $params
	 
## create



	 
 Rebuilds table for object, rebuild param drops existing tables
	 
 @param bool $rebuild
	 
## _createObjects



	 
 Launches table rebuilding for all objects in defined path
	 
 @param $rootPath
	 
 @param array $params
	 
 @throws \Core\Object
	 
## _prepareFields



	 
 Prepares fields for creating table
	 
 @return string
	 
## _dropTables



	 
 Drops all tables in database
	 
