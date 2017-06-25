<?php
if (!class_exists('ArevicoAppCommon')){

/**
 * This class contains methods that are used in both the admin 'app' as well ad the front-end and is meant to be extended by both
 *
 * @version 1.0
 * @package Core
 */
abstract class ArevicoAppCommon{

    protected $_registry    = null;

    /**
     * Add an filter hook to WordPress
     *
     * @param string $tag the tag we want to hook
     * @param callback|classinfo|callbackstring either a callback or callbackstring (if its an controller)
     * @param int prio The hook priority
     */
    public function addFilter( $tag, $callback, $prio = 10 ){
        $registry = $this->getRegistry();

        if (!is_callable($callback) )
            $callback = $this->getCallable( $callback );


        add_filter($tag, $callback, $prio);
    }

    /**
     * Add an action hook to WordPress
     *
     * @param string $tag the tag we want to hook
     * @param callback either a callback or callbackstring
     * @param int prio The hook priority
     */
    public function addAction( $tag, $callback, $prio = 10 ){
        $registry = $this->getRegistry();

        if (!is_callable($callback) )
            $callback = $this->getCallable( $callback );

        add_action($tag, $callback, $prio);
    }

    /**
     * Convert a controller callbackstring into a callable array
     *
     * @param $string callbackstring the callback string (f.e AdminController@process)
     * @param $string type not yet implemented
     * @todo make use of load class and type instead of loading a controller
     * @returns callable the callable method
     */
    public function getCallable( $callbackstring, $type = ArevicoRegistry::CLASS_CONTROLLER){
        $reg 		= $this->getRegistry();

		$callback 	  = $reg->classInfo( $callbackstring, $type);
        $instance     = $reg->getInstance($type, $callback->original);

        /** Make a new instance and inject an admin class  */
        if (is_null($instance ) ){
			$reg->loadClass($callback);
            $instance = new $callback->className( $this );
            $reg->register($type, $instance, $callback->original);
        }

        return array($instance, $callback->method );
    }


    /**
     *
     * @todo implement
     */
    public function loadLibrary( $path ){

    }

    /**
     *
     */
    public function style($handle, $src = false, $deps = array(), $ver = false, $media = 'all'){
       if ($src && !ArevicoSQA::isUrlRemote($src))
           $src = $this->getRegistry()->getPluginBaseUrl() . '/' . $src;

       wp_enqueue_style($handle, $src, $deps, $ver, $media);
       return $this;
    }

    /**
     *
     */
    public function script($handle, $src = false, $deps = array(), $ver = false){
        if ($src && !ArevicoSQA::isUrlRemote($src) )
            $src = $this->getRegistry()->getPluginBaseUrl()  . '/' .   $src;

       wp_enqueue_script($handle, $src, $deps, $ver);
       return $this;

    }

     /* Getters And Setters
     --------------------------------------------------------- */
     /**
      * Attach the registry to this instance
      * @param Registry $reg The registry object
      */
     public function setRegistry( $reg ){
        $this->_registry = $reg;
    }

    /**
     * Request access to the registry object
     * @ return Registry The registry
     */
    public function getRegistry(){
        return $this->_registry;
    }

    /**
     * Constructor
     *
     * @param Registry $reg The registry object
     */
    public function __construct( $reg ){
        $this->setRegistry( $reg );
    }

}

} // End Class Exists Check