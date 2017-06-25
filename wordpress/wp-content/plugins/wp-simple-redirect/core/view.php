<?php
 if (!class_exists('ArevicoView')){

/**
 * View Class
 *
 * @version 1.0
 * @package Core
 */
class ArevicoView{

    protected $_class_info        = '';

    protected $_registry;

    protected $_data        = array();
    protected $_output      = '';

    /*These strings are used to render various presentational elements
    ------------------------------------------------*/
	private static $tab 		 = '';
	private static $tabli 		 = '<a class="nav-tab a-%2$s nav-tab-%2$s tab-%3$s">%4$s</a>';
	private static $tabHeader 	 = '<div class="tab-container"><div class="tab-header"><h2 class="nav-tab-wrapper">%1$s</h2></div>';

	/* Some helper to get values from passed data fast
    ------------------------------------------------*/

	/**
	 * Get All error messages
	 *
	 * @param $error_1 .. $error_x
	 */
	public function getErrors(){
		$messages = array();

		$args = func_get_args();

		foreach ($args as $error)
				$messages = array_merge($messages, $error->getMessages() );

		return $messages;

	}

	public function idField( $id ){
		if ( $id !== null)
			echo "<input type=\"hidden\" name=\"id\" value=\"{$id}\" />";
	}

	public function idUrl($id , $echo = true){
		if ( $id == null)
			return '';
		
		$id = '&id=' .  htmlentities($id);

		if ($echo)
			echo $id;

		return $id;
	}

	public function nonceField(){
		wp_nonce_field(-1, '_arevico_actions', false, true);
	}

	public function nonceUrl( $echo = true ){
		$nonce 	= wp_create_nonce(-1);
		$nonce 	= '&_arevico_actions=' . $nonce;

		if ($echo)
			echo $nonce;

		return $nonce;
	}
	
	/**
	* Helper function to retrieve a value from an array or object
	*
	* @param string $name The path to the property in array notation
	*/
	public function _v($name, $object = null, $escape = true){
		return ArevicoSQA::val($name, $object, true, $escape);
	}


	public function _c($name, $object){
		$val = 		ArevicoSQA::val($name, $object, false, false);

		if (!empty($val))
			echo 'checked="checked"';
	}

	public function _s($name, $object, $against){
		$val = 		ArevicoSQA::val($name, $object, false, false);

		if (strcasecmp($val, $against) === 0 )
			echo 'selected="selected"';
	}

	/**
	 * Construct a header for the tab
     *
	 * @param array items, an array of items in the kvp form  id => Label
	 * @param bool echo wether or not to output the resulting html
	 */
	public static function getTabHeader($items, $echo = true){
		$lis 	= '';
		$i  	= 0;

		foreach ($items as $slug => $label) {
			$first  = ($i==0) ? 'first ' : '';
			$active = ($i==0) ? 'active ' : 'inactive';

			$lis .= sprintf(self::$tabli, $first, $active, $slug, $label);
			$i++;
		}

		$sret = sprintf(self::$tabHeader, $lis);
		if ($echo)
			echo $sret;

		return $sret;
	}

	/**
	 * Render a closing tab matching the opening header
	 */
	public static function closeTab(){
		echo '</div>';
	}

	/**
	 * Render an update message if applicable
     *
	 * @param string $message The update message
	 */
	public static function updateMessage($message = 'Saved Successfully!'){
		 if (self::$getState())
		 	echo "<div class=\"updated\">{$message}</div>";
	}


    /* External Facing methods
    ------------------------------------------------*/
    /**
     * Initialize the view and set the path
     *
     * @param callbackstring $classInfo Path to the view object
     * @return View returns an initialized view
     */
    public static function create( $classInfo, $controller = null ){
         return new self( $classInfo, $controller ); //dont we all wish too
    }

    /**
     * Includes the view object and get the content
     *
     * @param boolean $dontoutput Wether or not to echo the retrieved data or just to return it
     */
    public function render( $dontOutput = false){
       $base        = 'app/views/';

	   // Locals added do not show up in xDebug ,unfortunately
       extract ($this->_data);

       ob_start();
	       require $this->getRegistry()->getPluginBasePath() . $this->getPath() . '.php' ;
    	   $this->_output = ob_get_contents();
       ob_end_clean();

        if (!$dontOutput)
            echo $this->_output;

       return $this;
    }

    /* Various getters and setters
    -------------------------------------------*/
    public function getOutput(){
        return $this->_output;
    }

    public function with( $name, $value = null ){
		$args = func_get_args();
		$l 	  = func_num_args();

		if ($l==1){
			$this->_data = array_merge($this->_data, $args[0]);
			return $this;
		}

		for ($i=0; $i <	 $l ; $i = $i + 2)
        	$this->_data[$args[$i]] = $args[$i+1];

        return $this;
    }

    public function setData( $data ){
        $this->_data = $data;
        return $this;
    }

    public function getData( $key = null){
		if ( $key !== null)
			return isset($this->_data[$key]) ? $this->_data[$key] : null;
			
        return $this->_data;
    }

    function __construct( $classInfo, $reg = null ){
        $this->setClassInfo( $classInfo );
        $this->setRegistry( $reg );
    }

    public function section( $callback, $data = null ){
		if ($data == null)
			 $data = $this->getData();
        $this->getRegistry()->section( $callback, $this->getData() );
    }

    public function getRegistry(){
        return $this->_registry;
    }

    public function setRegistry( $reg ){
        $this->_registry = $reg;
        return $this;
    }

    public function getPath(){
        return $this->_class_info->path;
    }

    public function setClassInfo( $classInfo ){
        $this->_class_info = $classInfo;
        return $this;
    }
	
}

} // End Class Exists Check