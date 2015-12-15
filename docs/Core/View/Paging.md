# Core\View\Paging
## CONSTANTS

## PROPERTIES

#### _class
#### _curPage
#### _onPage
#### _paging
#### _collection
## METHODS

## __construct
## create



	 
 Return paging object
	 
 @param $className
	 
 @param array $params
	 
 @return static
	 
## _calculate



	 
 Requests objects from database
	 
 Calculates limit, offset, count
	 
## getPaging



	 
 Creates new view with paging data
	 
 @return string rendered paging template
	 
## needsPaging



	 
 Checks if collection requires paginating
	 
 @return bool
	 
## firstItemOnPage



	 
 Returns number of first item on the page
	 
 @return int
	 
## lastItemOnPage



	 
 Returns number of last item on the page
	 
 @return int
	 
## isFirstPage



	 
 Returns true if the page is first
	 
 @return bool
	 
## isLastPage



	 
 Returns true if the page is last
	 
 @return bool
	 
## getObjects



	 
 Returns array of fetched objects from database
	 
 required for concrete page
	 
 @return array
	 
