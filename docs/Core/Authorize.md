# Core\Authorize
## CONSTANTS

#### HASH_SALT
## PROPERTIES

#### _entity
#### _user
#### _oauth_hash
## METHODS

## __construct



	 
 Setups user authorizing entity, as string (Object name)
	 
 @param $entity
	 
## login



	 
 Login method
	 
 Accepts login, password and hash function for password security
	 
 Inserts user session hash to database and sets appropriate cookie
	 

	 
 @param string $login
	 
 @param string $password
	 
 @param \Closure $hashFunction
	 
 @param bool $remember
	 
 @throws \Exception
	 
## logout



	 
 Removes user session hash from database
	 
 and deletes auth cookie
	 

	 
 @throws \Exception
	 
## getUser



	 
 Returns authorized user
	 
 If user isn't set globally to App, requests from user session table by auth cookie
	 
 And sets authorized user to App
	 

	 
 @return bool|Object
	 
## hash



	 
 Hash function for security of user session hash and auth cookie value
	 
 @param $login
	 
 @param $password
	 
 @return string
	 
