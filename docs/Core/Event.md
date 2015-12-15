# Core\Event
## CONSTANTS

## PROPERTIES

#### _handlers
#### _listeners
## METHODS

## registerHandler



	 
 Registering event handler
	 
 @param EventHandler $handler
	 
## dispatch



	 
 Dispatches event
	 
 Can send data array and callback
	 
 @param $alias
	 
 @param array $data
	 
 @param null $callback
	 
## listen



	 
 Subscribe for event and run callback function when event will be run
	 
 @param $alias
	 
 @param bool $callback
	 
