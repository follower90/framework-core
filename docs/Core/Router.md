# Core\Router
## CONSTANTS

#### NOT_AUTHORIZED
#### NOT_FOUND_404
## PROPERTIES

#### _routes
#### _aliases
#### _url
#### _isApi
## METHODS

## getAction



	 
 Returns controller and method for executing
	 
 by requested URI
	 
 @param $lib
	 
 @return array|bool
	 
## _findMatches
## alias



	 
 Defines custom alias url for controller
	 
 @param string $url first url part
	 
 @param string $controller class name
	 
## _autoDetect



	 
 Autodetect appropriate route
	 
 @param $lib
	 
 @return array|bool
	 
## _returnAction
## getArgs



	 
 Combines Uri params with GET and POST data
	 
 @param $args
	 
 @return array
	 
## _sanitize



	 
 Removes slashes from Controller path
	 
 @param type $string
	 
 @return type
	 
## _initUrlParams



	 
 Writes requested uri, based on site.url
	 
 and 'isApi' = true, if Api request
	 
 @return array
	 
## register



	 
 Register custom route
	 
 @param $request
	 
 @param $controller
	 
 @param $action
	 
 @param $params
	 
## redirect



	 
 Simple redirect to URI
	 
 Accepts array of custom headers
	 
 @param $url
	 
 @param array $headers
	 
## get



	 
 Get Server Request params
	 
 @param string $param
	 
 @return string|bool
	 
## _matches



	 
 Checks match requested URI with registered custom routes
	 
 @param $route
	 
 @param $url
	 
 @return bool
	 
## sendHeaders



	 
 Sends http headers
	 
 @param $headers
	 
## route



	 
 Registers route
	 
 @param type $httpMethod
	 
 @param type $pattern
	 
 @param type $action
	 
 @return \Core\Router
	 
## _parseGetParams



	 
 Returns params from matched pattern
	 
 @param type $pattern
	 
 @return type
	 
