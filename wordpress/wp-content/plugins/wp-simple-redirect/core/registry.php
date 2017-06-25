<?php
if (!class_exists('ArevicoRegistry')){

/**
 * A class to keep track of objects
 *
 * @package Core
 * @version 1.0
 */
class ArevicoRegistry /* of citizens */{

    /** Variables For Naming Various object Types */
	const CLASS_CONTROLLER = 'Controller';
	const CLASS_VIEW 	   = 'View';
	const CLASS_MODEL 	   = 'Model';
    const CLASS_TABLE      = 'Table';
    const CLASS_LIBRARY    =  'Lib';

	const BASE_CONTROLLER 	= 'app/controllers/';
	const BASE_VIEW 		= 'app/views/';
	const BASE_MODEL 		= 'app/models/';
    const BASE_DEFAULT      = 'app/';
	const BASE_LIBRARY      = 'app/lib/';

    private $_instances = array();

    private $_namespace = '';
    private $_base_path = '';

    private $_db_prefix = '';

	/**
	 * Get the default storage url for classes based on the tpye of class (model, view or controller)
	 *
	 * @param string $type The type of class
	 */
	private function getTypeBasePath( $type ){
		$base = '';

		switch ($type) {
			case self::CLASS_CONTROLLER:
				$base = self::BASE_CONTROLLER;
				break;

			case self::CLASS_VIEW:
				$base = self::BASE_VIEW;
				break;

			case self::CLASS_MODEL:
				$base = self::BASE_MODEL;
				break;

			case self::CLASS_TABLE:
				$base = self::BASE_VIEW;
				break;

			case self::CLASS_LIBRARY:
				$base = self::BASE_LIBRARY;
				break;

			default:
				$base = self::BASE_DEFAULT;
				break;
		}

		return $base;
	}

	/** Remove an entry or all entries from the registry
	 *
	 * @param string $type The type to remove. If is_null the whole registry is cleared
	 * @param string $id The sepcific id to be removed. If empty than the whole registry type is cleared
	 * @retun void
	 */
	public function delete( $type =null, $id = null){
		if ($type == null){
			$this->_instances = array();

		} elseif( $id == null && isset($this->_instances[$type]) ){
			unset($this->_instances[$type]);

		} elseif( isset($this->_instances[$type], $this->_instances[$type][$id])) {
			unset($this->_instances[$type][$id]);
		}

	}

    /**
     * Register a controller class (overwrites if the ID already edxists)
     *
     * @param string $callback the callback in the form of 'Class@function'
     * @return Controller returns an instance of a controller.
     */
    public function register($type, $instance, $id){
        if ( !isset($this->_instances[$type]) )
            $this->_instances[$type] = array();

        $this->_instances[$type][$id] = $instance;
     }


   /* Getters And Setters
   --------------------------------------------------*/
    /**
     * Get the current namespace (prefix)
     * @return string $this->_namespace
     */
    public function getNamespace(){
        return $this->_namespace;
    }

    /**
     * Set the current namespace prefix
     * @param string $namespace The prefix to set
     * @return Registry $this
     */
    public function setNamespace( $namespace){
        $this->_namespace = $namespace;
        return $this;
    }

    /**
     * Look up a an identifier from a specific type in the registry
     *
     * @param string $type the type of entry. E.G: controller
     * @param string $id the id which we filed the instance uinder
     * @return mixed The instance of a specific type (loads the class if the isntance is of type classInfo)
     */
    public function getInstance( $type, $id ){
        $instance = isset($this->_instances[$type][$id])  ? ($this->_instances[$type][$id]) : null;
        return $instance;
    }

   /**
    * Get all instances from the registry
    *
    * @param string $type return all instances from a type or all
    * @returns array An array of instances
    */
   public function allInstances( $type = null){
       if (is_null($type))
        return $this->_instances;

        return $this->_instances[$type];
   }

    /**
     * Return a plugin url from the base path instead of relative to the __FILE__ of the caller
     * @TODO Check if this works
     * @param string $path the relative path
     * @return string the full URL to the resource
     */
    public function getPluginBaseUrl( $path = '' ){
        $plugin = $this->getPluginBasePath() . 'index.php';
        return plugins_url( $path, $plugin);
    }

    private function setPluginBasePath( $path ){
        $this->_base_path   = rtrim($path, '/' ) . '/'; 
    }
     /**
     * Retrieve a normalized version of __FILE__, traversed up to this plugins base
     *
     * @return string the full path to the base of this plugin
     */
    public function getPluginBasePath(  ){
        return $this->_base_path;
    }

    public function setDBPrefix( $prefix ){
        $this->_db_prefix = $prefix;
    }

    public function getDBPrefix(){
        return $this->_db_prefix;
    }

    /**
     * Init the registry
     *
     * @param $prefix the namespace prefix (since we can't use real namespace for backward compatibility with PHP5.0)
     * @return Registry $this
     */
    public function __construct( $prefix, $basePath){
        $this->setNamespace( $prefix );
        $this->setPluginBasePath( $basePath );
    }

    /* Factory Methods
    ------------------------------------------------------------ */
    /**
	 * A alias method to create a new view object and inject this registry
	 *
	 * @param $callback either a view object or a classinfo object
	 * @returns ArevicoView The constructed view object
	 */
     public function makeView( $callback, $register = false){
         $view  = null;

         $classinfo   = (ArevicoSQA::isClassInfo($callback)) ? $callback :
		 $this->classInfo( $callback, ArevicoRegistry::CLASS_VIEW );

		 if ( $register){
			 $view = $this->getInstance('views', $classinfo->original);

             if ($view === null){
           		 $view        = new ArevicoView( $classinfo );
                 $this->register('views', $view, $classinfo->original );
              }
        
        } else{
            $view = new ArevicoView( $classinfo );
        }

         return $view->setRegistry( $this );
     }

     /**
     * Include a class if we didn't do so already. Also prevent double loading
     * look at this as a 'diy'-autoloader
     *
     * @param string|Classinfo $classInfo If the callback is passed, the class info object is retrieved, otherwise its used.
     * @return Classinfo return the class info.
     */
    public function loadClass($classInfo,  $type = self::CLASS_CONTROLLER){
        if ( is_string($classInfo) )
            $classInfo = $this->classInfo($classInfo, $type);

        if ( class_exists($classInfo->className) === false )
            include strtolower($this->getPluginBasePath() .  $classInfo->path . '.php');

        return $classInfo;
    }

     /**
      * Create a model 
      *
      * @param string|callbackinfo $callback the callback
      * @param bool $register include it in the registry
      */
	 public function makeModel( $callback, $register = true){
		 $model = null;

    	 $classinfo   = (ArevicoSQA::isClassInfo($callback)) ? $callback : $this->classInfo( $callback, ArevicoRegistry::CLASS_MODEL );
		 $this->loadClass( $classinfo );

		 if ( $register) {
			 $model = $this->getInstance('models', $classinfo->original);

             if ($model === null){
				 $model = new $classinfo->className( $this );
	 			 $this->register('models', $model, $classinfo->original );
			 }

		} else {
			 $model = new $classinfo->className( $this );
		}
         return $model;
	 }

     /**
      * Make a new view and make sure all added variables are available in the new context
      *
      */
     public function section( $callback, $data){
         $view = $this->makeView( $callback );
         $view->setData( $data );
         return $view->render();
     }

    /**
     * Get the information of a callbackstring
     *
     * @param string $original The original string e.g AdminController@render, AdminController
     * @param string $method The default method if none is set
     * @param string $type The Type of class. Will be used as a suffix and calls the correct alias function for loadClass. Can be Controller, Model, View
     * @return stdClass returns a class with the following properties path, method, original, suffix, className
     */
    public function classInfo( $original, $type = self::CLASS_CONTROLLER, $method = 'get'){
        if (ArevicoSQA::isClassInfo($original) )
            return $original;

        $path       = explode('@', $original);
        $method     = isset( $path[1] ) ? $path[1] : $method;

        $path       = str_replace('.', '/', $path[0]) ;

		$className  = strrchr($path, '/');
		$className  = (!$className) ? $path : $className;
        $className  = ltrim( $className, '/');

        $className  =  $this->getNamespace() . ucfirst($className) . ucfirst($type);

		$path 		= strtolower($this->getTypeBasePath( $type ) . $path );

        // Canonize original identifier
		$original 	= strtolower($original);

        $classInfo = (object)get_defined_vars();

        return $classInfo;
    }

}

} // End Class Exists Check
