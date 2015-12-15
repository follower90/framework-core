# Core\View
## CONSTANTS

## PROPERTIES

#### _templateOptions
#### _defaultPath
#### _styles
#### _scripts
#### _noticeObject
#### _notices
## METHODS

## setOptions



	 
 Template params setter
	 
 @param $data
	 
## setOption



	 
 Single template param setter
	 
 @param $key
	 
 @param $value
	 
## loadResources



	 
 Return resources batch by type
	 
 @param string $type
	 
 @return string resources paths
	 
## render



	 
 Renders template with vars
	 
 @param $tpl
	 
 @param array $vars (do not rename it!)
	 
 @return string
	 
## renderString



	 
 Renders string with vars replacement
	 
 @param string $string
	 
 @param array $vars
	 
 @return string
	 
## setDefaultPath



	 
 Set path to folder with templates, etc.
	 
 @param $path string to public folder
	 
## load



	 
 Includes css/js/etc. file into template
	 
 Root path is "vendor path" for current entry point
	 
 Look into Html trait for setup concrete loading methods
	 
 @param $type
	 
 @param string $vars
	 
 @return string
	 
## _prepare



	 
 Prepares multiple resources
	 
 @param $type
	 
 @param array $paths
	 
 @return string
	 
## setNoticeObject
## addNotice
## getNotices
## renderNotices
## select



	 
 Renders select box
	 
 @param $optionsMap - requires key value params map
	 
 @param array $params - associative array, id, class, name
	 
 @param array $default - default key
	 
 @return string
	 
## loadCss



	 
 Generates style including link
	 
 @return string
	 
## loadJs



	 
 Generates javascript including link
	 
 @return string
	 
## loadPhtml



	 
 Generates javascript including link
	 
 @return string
	 
