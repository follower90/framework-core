# Core\App
## CONSTANTS

## PROPERTIES

#### _entryPoint
#### _debugParam
#### _vendorPath
#### _appPath
#### _user
#### _instance
## METHODS

## __construct



	 
 Sets application root path
	 
 and entry point
	 

	 
 @param EntryPoint $entryPoint
	 
## get



	 
 Returns App instance
	 
## __destruct



	 
 Show debugger console
	 
 in the end of application life cycle
	 
## run



	 
 Core application run method
	 
 Setups debugger, file including and error handling
	 
 Requests route and calls API/Controller
	 

	 
 @throws \Exception
	 
## setUser



	 
 Sets authorized user globally
	 

	 
 @param \Core\Object $user
	 
## setVendorPath



	 
 Get root path of vendor in current entry point
	 
 @param string $path
	 
 @return true
	 
## getVendorPath



	 
 Get root path of vendor in current entry point
	 
 @return string path
	 
## getAppPath



	 
 Get root path of application at server
	 
 @return string
	 
## getUser



	 
 Get authorized user object
	 
 @return bool|\Core\Object
	 
## _setupDebugMode



	 
 Setups debug-mode cookie
	 
 based on GET param
	 
## showDebugConsole



	 
 Gets debugger instance, gets all logged data
	 
 and renders template with debug console
	 

	 
 @param string $debug on/off
	 
 @todo refactor for allowed IPs configuration
	 
## _setFileIncludeHandler



	 
 Registering handler function for
	 
 logging included files into debugger
	 
## _setErrorHandlers



	 
 Logs PHP warnings, notices and fatal errors to debug console
	 
 Shows debug console immediately in case of fatal error
	 
