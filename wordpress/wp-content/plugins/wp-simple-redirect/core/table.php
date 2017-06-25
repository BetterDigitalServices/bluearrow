<?php
if (!class_exists('ArevicoTable')){

if(!class_exists('WP_List_Table'))
    include ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

/**
 * Add some extra convience to the WP_List_Table class
 *
 * @version 1.0
 * @package Core
 * @extends WP_List_Table
 */
class ArevicoTable extends WP_List_Table{
	
	/**  The ID field to be used in checkbox*/
	protected $_idField 	= 'id';

	protected $_registry 	= null;
	
	protected $_view 		= null;

	/**
	 * Render a checkbox column 
	 * 
	 * @todo check compatiblity of  $item->{$item->id_field}  
	 */
	public function column_cb( $item ){
		$item = (object)$item;
	    return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', 
			$this->_idField,
			ArevicoSQA::oVal($this->_idField, $item, '')
		);
	}
	
	/**
	 * Indicate which columns are sortable.
	 *
	 * @return array the array of columns that can be sorted
	 */
	public function get_sortable_columns(){
		return array();
	}
	
	public function get_hidden(){
		return array();
	}

	/**
	 * Initilize the table before rendering
	 */
    public function prepare_items( ) {
        $columns 	= $this->get_columns();
        $hidden 	= $this->get_hidden();
        $sortable 	= $this->get_sortable_columns();

        $this->_column_headers = array($this->get_columns(), $hidden, $this->get_sortable() );
   }

   /**
    * Display the Table
	*/
   public function render(){
	   $this->prepare_items();
	   $this->display();
   }

	/**
	 * Set the pagination settings for rendering the correct links. (does not paginate)
	 *
	 * @param ArevicoPaginateInfo $paginateInfo The pagination settings
	 */
	public function paginate( $paginateInfo){
        $this->set_pagination_args( array(
            'total_items' => $paginateInfo->items,                  //WE have to calculate the total number of items
            'per_page'    => $paginateInfo->per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => $paginateInfo->getNumberOfPages()   //WE have to calculate the total number of pages
        ) );
    }

	public function getRegistry(){
		return $this->_registry;
	}

	public function setRegistry( $reg ){
		$this->_registry = $reg;
	}
	
	/**
	 * Provides access to the parent view, so we can use all the nice methods it exposes
	 *
	 */
	public function setView( $view ){
		$this->_view = $view;
		return $this;
	}

	public function getView( ){
		return $this->_view;
	}

	/**
	 * Initilize a new Table Object
	 *
	 * @param $data The data associated with the table
	 * @param $singular The singular name of the table (e.g. movie)
	 * @param $plural The plural name of the table (e.g. movies)
	 */
    function __construct( $data, $singular, $plural, $id_field = ''){
        parent::__construct( array(
            'singular'  => $singular,
            'plural'    => $plural,
            'ajax'      => false
        ) );

        $this->items 	= $data;
		$this->id_field = $id_field;
	}
}

} // End Class Exists Check