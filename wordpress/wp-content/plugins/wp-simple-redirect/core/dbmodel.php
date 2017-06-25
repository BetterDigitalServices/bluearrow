<?php
if (!class_exists('ArevicoDBModel')){

/**
 * Model Class
 *
 * @version 1.0
 * @package Core
 */	
class ArevicoDBModel{

  	protected $_registry  	= null;
	protected $_error 		= null;

	/** Lets expose an ID object so we can keep track of the state,
	 * we don't pass it to the db functions but it makes it easier to add state to a DB Model 
	 * id can have the following values
	 * - ''   means no object is instantiated (create a new one perhaps)
	 * - null means not found or not set
	 * - Numeric means the ID exists (and is being edited)
	 */

	protected $_id 			= null;
	/**
	 * The database class associatd with the main odbc_fetch_object
	 * @var ArevicoDB
	 */
	protected $_db 			= null;

	/** Fillable contains all fields which may be included in the query. Note that primary key field may be added manually by bussine logic*/
	protected $_fillable 	= array();

	/** Boolean fields have the default value of (int)'0' instead of (string)'0' */
	protected $_bools 		= array();

	/**
	 * This function prepares database data to be used in inserts
	 *
	 * @param array $data the data to be prepared
	 */
	public function fillable( $data ){
		$data = ArevicoSQA::incArray($data, $this->_fillable);

		foreach ($this->_fillable as $field) {
			 if ( (!isset($data[$field])) || $data[$field] == null )
				$data[$field] = in_array($field, $this->_bools) ? '0' : '';
		  }

	  return $data;
	}

	public function __construct( $reg ){
	  $this->_registry 	= $reg ;
	  $this->_error 	= new ArevicoError();
	}

	public function getDB(){
	  return $this->_db;
	}

	public function getError(){
		return $this->_error;
	}

	public function getRegistry(){
		return $this->_registry;
	}

	public function setID( $id, $checkExists = true){
		if ($id == '' || $id == null){

		} else{
			if ($checkExists && !$this->getDB()->exists($id) )
				$this->_id = null;
		}

		$this->_id = $id;
	}

	public function getID(){
		return $this->_id;
	}
	
	/**
	 * redirect to an URL if the action was an insert (no ID associated) and there were no error!
	 */
	public function redirectInsertSuccess( $url ){
		if ( ArevicoSQA::isPost() &&  !( $this->_error->hasError() || $this->_id != null) )
			wp_redirect($url);
	}

	public function issetID(){
		return $this->_id != null; // on false, ''  or null
	}  

	/* Proxy functions for $this->getDB()
	-------------------------------------------------------------- */
	public function delayQuery(){
		return $this->getDB()->delayQuery();
	}

	public function all($return_type = OBJECT_K , &$paginate = null){
		return $this->getDB()->all($return_type, $paginate);
	}

	public function find($id = null, $return_type = OBJECT_K, $paginate = null){
		return $this->getDB()->find($id, $return_type, $paginate);
	}

	public function findRelation( $column, $id ){
		return $this->getDB()->findRelation( $column, $id );
	}

	public function paginate( &$paginate ){
		return $this->getDB()->paginate($paginate);
	}

	public function insert($data){
		$data 		= $this->fillable($data);
		$insertid 	= $this->getDB()->insert($data);
		$this->_id 	= $insertid;

		return $insertid;
	}

	public function update( $id, $data ){
		$data = $this->fillable($data);
	
		if ($id === null)
			return $this->insert( $data );
	
		return $this->getDB()->update($id, $data);
	}

	public function delete( $ids, $extraConditions = null ){
		return $this->getDB()->delete($ids, $extraConditions);
	}

}

} // End Class Exists Check