<?php
/**
 * Class that loads and or upgrade the database when activated ( and when neccesary )
 *
 * @package App
 * @version 1.0
 */
class arvalAppActivate {

	private $_registry 		 = null;

	/** DB Versio Control Options */
	private $_option_name 	 	= '';
	private $_current_version 	= '1';

	/**
	 * Queries to construct main database
	 *
	 */
	private $queries = array(
		'redirects' => 'CREATE TABLE IF NOT EXISTS `{$prefix}redirects` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,  `name` VARCHAR(255) NULL,  `slug` VARCHAR(255) NULL,  `match_type` INT NULL DEFAULT 0,  `encode` TINYINT(1) NULL DEFAULT 0,  PRIMARY KEY (`id`)) {$charset_collate};',
		'targets' 	=> 'CREATE TABLE IF NOT EXISTS `{$prefix}targets` (  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,  `redirect_id` INT UNSIGNED NULL,  `url` LONGTEXT NULL,  `redirect_type` VARCHAR(45) NULL,  PRIMARY KEY (`id`)) {$charset_collate};'
	);

	private $db = array(
		'1' => 'redirects',
		'2'	=> 'targets'
	);

	/**
	 * The ALTER statements or any other statement to get to the new database state are listed here.
	 * @example array( '1' => array('query_1', 'query_2') )
	 */
	private $alter = array(

	);

	/**
	 * @todo check database version
	 *
	 */
	public function install(){
		global $wpdb;
	
		/* Set some sensible defaults if no options are set */
		if (get_option('arval_sl', null) === null)
			update_option('arval_sl', array('global_prefix' => '/go/' ));
		
		// Prepare queries for DB Delta
		foreach ($this->db as &$query) 
			$wpdb->query( $this->modifyQuery($this->queries[$query]) );

		$this->update();	

		// Update Version
		update_option($this->_option_name, $this->_current_version);	
	}

	/**
	 * Execute a series of alter scripts
	 *
	 */
	public function update(){
		$version = get_option($this->_option_name, $this->_current_version);

		for ($i = $version; $i < $this->_current_version ; $i++) { 
			$this->updateFromVersion($i);
		}

	}

	/**
	 * Update from a particular version to the next
	 *
	 * @param string $currentVersion the version from which we want to update
	 */
	public function updateFromVersion( $currentVersion ){
		global $wpdb;

		if (!isset($this->alter[ $currentVersion ]))
			return;

		foreach ($$this->alter[ $currentVersion] as $sql) 
			return $wpdb->query( $this->modifyQuery($sql) );
	}

	

	/**
	 * Delete tables in order from the database
	 *
	 * @param string $table,... The tables we want to have deleted from teh database
	 */
	private function dropTable($table){
		global $wpdb;
		$tables = func_get_args();
		$sql 	= implode(',', $tables);
		$wpdb->query('DROP TABLE IF EXISTS {$tables}');
	}

	/**
	 * Modify the query to include placeholders ,etc, prefixes
	 * 
	 * @param $query string the query we want to adjust
	 * @return string The new query
	 */
	 public function modifyQuery( $query ){
		 global $wpdb;
		 $prefix 	= $wpdb->prefix . $this->getRegistry()->getNamespace() . '_';
		 $query 	= str_replace('{$prefix}',  $prefix, $query);
		 $query 	= str_replace('{$charset_collate}', $wpdb->get_charset_collate(), $query);

		 return $query;
	 }

	/**
	 *
	 *
	 */
	public function getRegistry(){
		return $this->_registry;
	}

	/**
	 * Initilize a new activate object
	 *
	 * @param Registry the registry`
	 */
	function __construct( $registry ){
		$this->_registry  	= $registry;
		$this->_option_name = $registry->getNamespace() . '_db_version';
	}

}