# Core\Validator
## CONSTANTS

## PROPERTIES

#### _rules
#### _request
#### _rulesList
## METHODS

## __construct



	 
 @param $rules array, example: [ 'test' => [ 'validator' => 'text', 'message' => 'Not a text' ]];
	 
 @param $request array, example: [ 'test' => 2234 ];
	 
 set rules and fields to $this
	 
## validate



	 
 Return result (success:true|false)
	 
 and errors list (field => error_text), or empty array
	 
 @return array
	 
## _validate



	 
 Applies validation method to the field according to the rule
	 
 @param $field
	 
 @param $rule
	 
 @return bool
	 
## isNotEmpty



	 
 Return false, if value is not set, or empty
	 
 @param $val
	 
 @return bool
	 
## isText



	 
 Returns false, if value is not text string
	 
 @param $val
	 
 @return bool
	 
