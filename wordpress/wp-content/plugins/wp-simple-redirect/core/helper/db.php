<?php
if (!class_exists('ArevicoDB')){

/**
 * Database helper Class
 *
 * @package Core/Helper
 * @version 1.0
 */
class ArevicoDB{

	public $_tableName   	  	= '';
	protected $_original_table 	= '';

	protected $_primary         = 'id';
	protected $_registry        = null;

	/** Part of a very simple query builder*/
	public $query            = null;

	/** Don't execute automatically so we can edit the query a bit*/
	protected $delay_query   = false;

	/**
	 * Convert the parts of the sql query to a real sql query now
	 *
	 * @return string the real sql query
	 */
	public function toSQL(){
		$sql = '';

		if ($this->query['SELECT'] == '')
			$this->query['SELECT']= '*';

		foreach ($this->query as $key => $value) {
			if ($value !== '')
				$sql .= "{$key} {$value} ";
		}
		return $sql;

	}

	/**
	* Don't execute queries, but save all SQL Parts so we can modify it a bit later
	 */
	public function delayQuery(){
		$this->delay_query = true;
		return $this;
	}

	/**
	 * Execute delayed (stored) queries or custom SQL
	 *
	 * @param string $sql the querie to be executed (when null, retrieves stored query)
	 * @param string $return_type How the query should be returned 
	 */
	public function getResults( $sql = null, $return_type = OBJECT_K ){
		global $wpdb;
		$sql    = $sql == null ? $this->toSQL() : $sql;
		$res = $wpdb->get_results($sql, $return_type);
		$this->initQuery();
		return $res;
	}

	/**
	 * Add part of the sql query and conect it if there are already condition
	 *
	 * @param string $part the query part (e.g: select)
	 * @param string $condition the condition (or value)
	 * @param string $connector How to connect it (and / or )
	 * @return ArevicoDB the current db instance (fluid interface)
	 */
	public function query( $part, $condition, $connector = null){
		if ( !isset($this->query[strtoupper($part)]) )
			return $this;

		if ($connector == null ){
			if ( strcasecmp($part, 'select') === 0  ||
				 strcasecmp($part, 'from') === 0 ){
				$connector = ', ';
			} else {
				$connector = ' AND ';
			}
		}

		if (strcasecmp($part, 'where') === 0 )
			$condition = "($condition)";

		$this->query[$part] = empty($this->query[$part])  ? $condition : $this->query[$part] . $connector . $condition;

		return $this;
	}

	/**
	 * Find rows in the database
	 *
	 * @param string $id Primary key
	 * @param $return_type The query return type. can either be OBJECT_K, OBJECT, ARRAY_A, ARRAY_N
	 */
	public function find( $id = null, $return_type = OBJECT_K, $paginate = null){
		global $wpdb;

		if ( $id==null )
			return $this->all( $return_type , $paginate);

		$this->query['SELECT']   = '*';
		$this->query['FROM']     = $this->getTable();
		$this->query['WHERE']    = $this->getKey() . '="' . esc_sql($id) . '"';

		if ($paginate != null )
			$this->paginate( $paginate );

		$res      = $wpdb->get_results($this->toSQL(), $return_type, $paginate);

		$this->initQuery();
		$firstKey =  ArevicoSQA::firstKey($res);
		return $firstKey != null ? $res[$firstKey] : array();
	}


	public function findRelation( $column, $id ){
		global $wpdb;
		$this->delayQuery();
		$this->all();
		$this->query['WHERE'] = $wpdb->prepare("{$column} =  %s", $id);
		return $this->getResults();
	}

	/**
	 * Find rows in the database
	 *
	 * @param string $id Primary key
	 * @param $return_type The query return type. can either be OBJECT_K, OBJECT, ARRAY_A, ARRAY_N
	 */
	 
	/**
	 * Find all object from  the database
	 *
	 * @param $return_type The query return type. can either be OBJECT_K, OBJECT, ARRAY_A, ARRAY_N
	 */
	public function all( $return_type = OBJECT_K , &$paginate = null){
		global $wpdb;

		$this->query['SELECT']   = '*';
		$this->query['FROM']     = $this->getTable();

		if ($paginate != null )
			$this->paginate( $paginate );

		if ($this->delay_query)
			return;

		$res = $wpdb->get_results($this->toSQL(), $return_type);

		$this->initQuery();
		return $res;
	}

	/**
	  * Check if a column value pair already exists in the database
	  *
	  * @param $column the column we which to check
	  * @param $value The (unescaped) value we wish to check against
	  * @param trim the spaces of a field
	  */
	 public function exists($column = null, $value = null, $extra = '', $trim = true){
		 global $wpdb;

		if (func_num_args()<=2){
			$value 	= func_get_arg(0);
			$column = $this->getKey();
		}

		 if ($trim)
			$value = trim($value);

		 $table = $this->getTable();
		 return $wpdb->get_var($wpdb->prepare("SELECT EXISTS(SELECT * FROM {$table} WHERE {$column}=\"%s\" {$extra})", $value));
	 }

	 /**
	  * Add pagination info, executes a changed version of the current query to get the number of row
	  * Make sure to call this function last
	  *
	  * @param PaginateInfo $paginateinfo the pagination parameters
	  */
	 public function paginate($paginateinfo ){
		global $wpdb;
		$old_select = $this->query['SELECT'];

		$this->query['SELECT'] = 'count(*) as num_rows';
		$paginateinfo->items = $wpdb->get_var( $this->toSQL()) ;

		$offset = ($paginateinfo->paged - 1 ) * $paginateinfo->per_page ;
		$this->query['LIMIT']       = $offset . ' , ' . ($offset + $paginateinfo->per_page);
		$this->query['ORDER BY']    = $this->getKey() . ' ASC'; // Newley inserted first
		$this->query['SELECT']      = $old_select;
	 }

	 /**
	  * Retrieve the ID of the last inserted Row
	  */
	 public function insertID(){
		global $wpdb;
		return $wpdb->insert_id;
	 }

	/**
	 * Add a data to the database
	 *
	 * @param array|object $data unescaped data to insert into the table
	 */
	public function insert( $data ) {
		global $wpdb;
		$data = (array)$data;
		$wpdb->insert($this->getTable(), $data);
		return $wpdb->insert_id;
	}

	/**
	 * Update the db
	 * 
	 * @param string $id the id
	 * @param mixed $data the new table
	 */
	public function update($id, $data){
		global $wpdb;

		if ($id === null)
			return $this->insert( $data );
			
		$key = $this->getKey();
		$data = (array)$data;
		unset($data[$key]);

		$table  = $this->getTable();
		$where  = array( $key => $id);
		return $wpdb->update($table, $data, $where);
	}

	/**
	 * Delete veraious rows from the current table
	 *
	 * @param mixed $ids The primary keys of the rows to be deleted
	 * @param string $extraConditions add a where clause
	 */
	public function delete($ids, $extraConditions = null){
		global $wpdb;
		$ids 	= esc_sql($ids);
		$ids    = (is_array($ids)) ? implode("','", $ids) : $ids;

		$table 	= $this->getTable();
		$key 	= $this->getKey();
		$extraQueryPart = ($extraConditions === null) ? '' : "( {$extraConditions} )";

		// If no ID is sepcified, all are deleted (probably want to specify extraconditions)
		$key 	= empty($ids) ? '' : "{$key} IN ('{$ids}')";

		// Add a Connector if there is a condition
		if ($extraConditions !== null && !empty($key))
			$extraQueryPart = " AND {$extraQueryPart}";

		$sql    = "DELETE FROM {$table} WHERE {$key} {$extraQueryPart}";	

		return $wpdb->query($sql);
	}

   /* Getters And Setters
	 ------------------------------------------------------ */
	/**
	 * Get the processed table name (with prefixes)
	 *
	 * @return string The table name
	 */
	public function getTable(){
		return $this->_tableName;
	}

   /**
	* Set the new primary keys
	*
	* @param string $key The primary key
	*/
   public function setKey( $key ){
		$this->_primary = $key;
		return $this;
   }

   /**
	* Get the primary key
	*
	* @return string the primary key
	*/
   public function getKey(){
	   return $this->_primary;
   }

   /**
	* Set the database table of the model. If it's a WordPress Defines table, it is automatically prefixed
	* if not, we apply the database prefix and the local prefix
	*
	* @param string $table The table name 
	* @param bool $prefixCheck 
	*/
	public function setTable( $table, $prefixCheck = true){
		global $wpdb;

		// we also like to store the table without any prefixes
	 	$this->_original_table = $table;

		if ($prefixCheck && isset($wpdb->$table)){
			$table = $wpdb->$table;

		} else {
			/** @todo: Move to the registry */
			$table =   $this->getRegistry()->getDBPrefix() .  $table;
		}

		$this->_tableName = $table;
		return $this;
	}

	/**
	 * Inject the registry dependency
	 *
	 * @param Registry $registry An registry instance
	 */
	public function setRegistry( $registry ){
		$this->_registry = $registry;
		return $this;
	}

	/**
	 * Get the attached registry instance
	 *
	 * @return registry the attached registry
	 */
	public function getRegistry(){
		return $this->_registry;
	}

	/**
	 * Create a new arevicodb instance
	 *
	 * @param Registry $reg The registry object we need to get the 'namespace'
	 * @param string $table The table name. If it's a wordpress table it isn't prefixed, otherwise, it is/
	 * @param string $primary the primary id if the table
	 */
	public function __construct( $reg, $table = null, $prefixCheck = true, $primary = 'id'){
		$this->setRegistry( $reg );
		$this->setKey( $primary );
		$this->initQuery();

		if ( $table !=null )
		  $this->setTable( $table, $prefixCheck);

	}

	private function initQuery(){

	   $this->delay_query = false;
	   $this->query= array(
			'SELECT'    => '',
			'FROM'      => '',
			'WHERE'     => '',
			'HAVING'    => '',
			'GROUP BY'   => '',
			'HAVING'    => '',
			'ORDER BY'  => '',
			'LIMIT'     => ''
		);
	}
	
}

} // End Class Exists Check