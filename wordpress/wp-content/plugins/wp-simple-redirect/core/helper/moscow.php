<?php
if (!class_exists('ArevicoSQA')){

/**
 * This class provides some auxiliary functions to aid database processing and HTML outputF$
 *
 * @package Core/Helper
 * @version 1.0
 */
class ArevicoSQA
{

	/**
	 * Retrieve the first element of an array
	 *
	 * @param array &$arr The array of which the first element is to be retrieved
	 * @return mixed the first element of an array
	 */
	public static function firstKey($arr){
		reset($arr);
		return key($arr);
	}

	/**
	 * Retrieve the first element of an array
	 *
	 * @param array &$arr The array of which the first element is to be retrieved
	 * @return mixed the first element of an array
	 */
	public static function lastKey($arr){
		end($arr);
		return key($arr);
	}

	/**
	 * Check if a value is available in the post array and return or output it encoded
	 *
	 * @param string $name the name and subname
	 * @param array|object $arr the array to fetch
	 * @param boolean $echo wether or not to output the current variable
	 * @param boolean $escape wether or not escaping the output is wished
	 * @example ArevicoSQA::val('option[subarray][value]')
	 * @return string the value
	 */
	public static function val($name, $arr = null, $echo = false, $escape = true, $notFound = ''){
		$str_ret 	= 	self::oVal($name, $arr, $notFound);

		if ($escape)
			$str_ret 	= htmlentities($str_ret);

		if ($echo)
			echo $str_ret;

		return $str_ret;
	}

	/**
	 * Set a value of a supplied object
	 * 
	 * @param string $name path notation to an object
	 * @param object &$object the object which we want to have changed
	 * @param mixed $value the new value
	 */
	public static function oSet($name, &$object, $value=null){
       $name    = preg_split('/(\\-\\>|\\[)/', $name); // we can use both the array syntax )[123] or the object one (->)
       $ret     = $notFound;
	   
	   $o_ref 	= $object;

       foreach ($name as $keyName) {
           $keyName     = rtrim($keyName, ']');

          if ( is_array($o_ref) && isset($o_ref[$keyName] ) ){
              $o_ref = &$o_ref[$keyName];

          } elseif ( is_object($o_ref) && isset($o_refarr->$keyName )){
             $o_ref = &$o_ref->$keyName;
          } else {
              return $notFound; // no valid entry or no entry at all
          }
       }

        return $arr;		
	}

	/**
	 * Cache a specific piece of data
	 *
	 * @param mixed $callback If it's callable the return value from the function gets cached,otherwise, the content passed
	 * @param array $parameters 	The parameters to be passed to the callback functio
	 * @param int $id 			(optional) The id of the caching reference.
	 * @param int $expire 		How long does the cache entry persists
	 */
	public static function cache($callback, $parameters=array(), $id = null, $expire = 24){
		$content 	= get_transient($id );

		if (!$id)
			$id = self::cacheGetId($parameters);

		if (!$content){
			$content = (is_callable($callback)) ? call_user_func_array($callback, $parameters) : $callback;
			set_transient($id , serialize($content), $expire );

		} else{
			$content = unserialize($content);
		}

		return $content;
	}

	/**
	 * Generate an unique identifier to store the cache entry. Asumed is that a call to a method_exists
	 * with the same parameters results in the same output. If any other conditions change, the cache
	 * Needs to be cleared manually.
	 *
	 * @param array $argument_list all the parameters
	 */
	public static function cacheGetId($argument_list = array() ){
		$id 			= sha1(serialize($argument_list));
		return substr($id, 5);
	}

    /**
     * Get all values of an array with a specific key
	 *
     * @param array $arr The array subjected
     * @param string $x1 .. $n  A variable argument list with array keys.
     */
    public static function incArray($arr /* , .. , */){
        $args = func_get_args();
        array_shift($args);

        if ( is_array($args[0]) )
            $args = $args[0];

        return array_intersect_key($arr, array_flip($args) );
    }

    /**
     * Get all values of an array not having a specific key
	 *
     * @param array $arr The array subjected
     * @param string $x1 .. $n  A variable argument list with array keys.
     */
    public static function excArray($arr /* , .. , */){
        $args = func_get_args();
        array_shift($args);

        if ( is_array($args[0]) )
            $args = $args[0];

        return array_diff_key($arr, array_flip($args) );
    }

	/**
	 * Return a value of a subarray by supplying a path int the form of a[b] or a->b
     *
	 * @todo Rename to oVal
	 * @param string $name the path to the value e.g(option[subarray][value]) , object properties have the same syntax
	 * @param array|object $arr the array or objectto traverse
	 */
    public static function oVal($name, $arr = null, $notFound = ''){
	if ($arr===null)
            $arr = $_POST;

		if ($name == '')
			return $arr;

       $name    = preg_split('/(\\-\\>|\\[)/', $name); // we can use both the array syntax )[123] or the object one (->)
       $ret     = $notFound;

       foreach ($name as $keyName) {
           $keyName     = rtrim($keyName, ']');

          if ( is_array($arr) && isset($arr[$keyName] ) ){
              $arr = $arr[$keyName];

          } elseif ( is_object($arr) && isset($arr->$keyName )){
             $arr = $arr->$keyName;
          } else {
              return $notFound; // no valid entry or no entry at all
          }
       }

        return $arr;
    }

	/**
	 * Convert parts to an access string for oVal
	*  @param mixed $x1 .. $xn The template parts. If the second parameter is an array, those will be used as parts
	 */
	 public static function getAccessString(){
		 $parts = func_get_args();
		 $parts = isset($parts[0]) && is_array($parts[0]) ? $parts[0] : $parts;

		 if (count($parts) == 0)
		 	return '';

 		 $access_string 	= array_shift($parts);  // The base

		  foreach ($parts as $part)
		  	$access_string .= '[' . $part . ']';

		return $access_string;


	 }

	/**
	 * This function converts an associative array to a single string with all elements
	 * delimited
	 * @param array $assoc the associated array
	 * @param string $delim the delimiter to seperate the values
	 * @return string A string in the format [key="value" ]
	 */
	public static function assocToString($assoc, $delim = ' ', $escape=true){
		global $wpdb;
		$arr_ret = array();

		foreach ($assoc as $key => $value) {
			if ($escape)
				$value=esc_sql($value);
			$arr_ret[]="{$key}=\"{$value}\" ";
		}
		return implode($delim, $arr_ret);
	}

	/**
	 * Return wether or not the current request is a post one
	 * @return bool true if the request is a post
	 */
	public static function isPost(){
		return 	$_SERVER['REQUEST_METHOD']==="POST";
	}

	/**
	 * Returns the full current url being displayed
	 *
	 * @todo WARNING!! Might not play nice with rewrites
	 * @return string the current URL including method and querystring
	 */
	public static function getCurrentURL(){
		//$_SERVER['REQUEST_URI']
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https')
                === FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];

		$currentUrl = $protocol . '://' . $host . $script . '?' . $params;

		return $currentUrl;
	}

	/**
	 * Check wether or not a local resource is being accessed
	 *
	 * @param string $url The url
	 */
	public static function isUrlRemote( $url ){
			$url = strtolower($url);
			return strpos($url,'//')  === 0 || strpos($url,'http://')  === 0 || strpos($url,'https://')  === 0;
	}

    /**
     * Check if the supplied argument is indeed a (custom) classInfo array
     * @return boolean true: the supplied object is of type classInfo
     */
    public static function isClassInfo( $classInfo ){
        return (is_array($classInfo) && isset($classInfo->original, $classInfo->path, $classInfo->method, $classInfo->className ) );
    }

	/**
	 * Check if an id is set in the corresponding request variables (e.g $_POST on post, $_GET on get)
	 *
	 */
	public static function getId($default = '', $echo = false){
		$id = self::isPost() ? self::oVal('id', $_POST, $default) :	self::oVal('id', $_GET, $default);

		if ($id !== null)
			$id = htmlentities($id);

		if ($echo)
			echo $id;

		return $id === null ? $default : $id;
	}

	/* 
	--------------------------------------------------------- */
	/**
	 * Joing two wpdb result sets together, on a foreign key
	 *
	 * @param OBJECT_K $main The main data
	 * @param OBJECT|OBJECT_K $secondairy the foreign data 
	 * @param string $referenceColumn The column containing the foreign reference
	 * @param string $fieldName an unique fieldname that will contain the relationship
	 */
	public static function oneToMany( $main , $secondairy, $referenceColumn, $fieldName){
		foreach ( $main as &$row )
			$row->$fieldName = array();

		foreach ($secondairy as $row_id => $row){
			if (!isset($row->{$referenceColumn}) )
				continue;

			$main[$row->{$referenceColumn}]->{$fieldName}[] = $row;	
		
		}
		return $main;
	}

	/**
	 * Joing two wpdb result sets together, on a foreign key
	 *
	 * @param OBJECT_K $main The main data
	 * @param OBJECT|OBJECT_K $secondairy the foreign data 
	 * @param string $referenceColumn The column containing the foreign reference
	 * @param string $fieldName an unique fieldname that will contain the relationship
	 */
	public static function oneToOne( $main, $secondairy, $referenceColumn, $fieldName){

		foreach ($secondairy as $row_id => $row){
			$foreignID  	= $row->$referenceColumn;

			if (!isset($main[ $foreignID ]))
				continue;

			$main[ $foreignID ]->$fieldName = $row;
		}
		
		return $main;
	}

}

} // End Class Exists Check