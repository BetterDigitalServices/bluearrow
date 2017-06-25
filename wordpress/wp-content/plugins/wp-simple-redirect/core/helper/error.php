<?php
if (!class_exists('ArevicoError') ){

/**
 * A class to faciliate logging and retrieving error messages. Please, note that there are two
 * seperate use cases of this object and it should not be mixed. One error object should be associated with
 * one database table or option group.
 *
 * @package Core/Helper
 * @version 1.0
 */
class ArevicoError
{

	public $error 		= array();
	public $data 		= array();


	public function hasError(){
		return !empty( $this->error );
	}

	public function addData($data, $dataId = 'data'){
		$this->data[ $dataId ] = $data;
	}

	public function getData( $dataId = 'data'){
		return $this->data[ $dataId ];
	}

	/**
	 * When this function has three arguemnts, an extra id is associated
	 *
	 * @param string $message the message we wish to add.
	 * @param string $key_1 .. $key_x One ore more keys associated with the error
	 */
	public function addError( $message, $keys) {
		$keys 	= array_slice(func_get_args(), 1);
		$keys 	= implode($keys , '->');

		if ( !isset($this->error[ $keys ] ))
			$this->error[$keys ] = array();

		$this->error[ $keys ][] = $message;

		return true;
	}

	/**
	 * Return an array of all error messages
	 *
	 * @param optional $key if there are multiple rows with the same validation, this is the id
	 * return array The error messages
	 */
	public function getError( $key , $errorId = ''){
		$args 	= func_get_args();
		if ( count($args)==2 ){
			return isset( $this->_error[ $args[0] ], $this->_error[ $args[0] ][ $args[1] ]) ? $this->_error[ $args[0] ][ $args[1] ] : array();
		} else {
			return isset( $this->_error[ $args[0]]) ? $this->_error[ $args[0] ] : array();
		}
	}

	/**
	 *
	 */
	public function getErrors(){
		return $this->error;
	}

	/**
	 * Retrieve a JSON representation of the error object
	 *
	 * @param $string $path An optional path to the sub option. This helps to make it easier to access elemens via jQuery
	 * 					   [*] Only support the -> notation forexample o or o->pa
	 */
	public function getErrorsJSON( ){

		$path 	= func_get_args();

		$errors = $this->getErrors();
		$ret 	= array();

		foreach ($errors as $key => $messages) {
			$parts = explode('->', $key);
			// Add base path e.g. [o, pa]
			$parts = array_merge($path, $parts);
			$key = ArevicoSQA::getAccessString($parts);

			$ret[$key] = $messages;
		}

		echo wp_json_encode($ret);
	}

	/**
	 *
	 */
	public function getMessages( ){
		$errors 	= $this->getErrors();
		$messages 	= array();

		foreach ($errors as $key => $msg) {
			$messages = array_merge($messages, $msg);
		}

		return $messages;
	}

}

} // End Class Exists Check