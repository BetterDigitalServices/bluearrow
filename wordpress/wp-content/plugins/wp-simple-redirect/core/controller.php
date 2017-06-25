<?php
if (!class_exists('ArevicoController')){

/**
 * A Controller Object
 *
 * @version 1.0
 * @package Core
 */    
class ArevicoController{

    private $_app  = null;
    private $_request_vars = null;

     /* Exposed Functionality
     -------------------------------------------------------------*/
     public function assets(){
         $app = $this->getApp();
         $app->style('arevico-admin-css', 'core/public/admin-css/style.css')->style('arevico-grid-css', 'core/public/grid/table-grid.css');
         $app->script('arevico-tab-js', 'core/public/tabs/tabs.js')->style('arevico-tab-css', 'core/public/tabs/style.css');
     }

     public function makeView( $callback, $register = true){
		 return $this->getRegistry()->makeView($callback, $register);
	}

	 public function makeModel( $callback, $register = true){
		return $this->getRegistry()->makeModel($callback, $register);
	 }

     public function section( $callback, $data ){
         $this->makeView( $callback )->setData($data)->render();
     }

     /* Getters And Setters
     -------------------------------------------------------------*/
     public function setApp( $app ){
         $this->_app = $app;
         return $this;
     }

     public function getApp(){
         return $this->_app;
    }

    public function getRegistry(){
        return $this->getApp()->getRegistry();
    }

    public function __construct( $app ){
       $this->_app = $app;
        $this->_request_vars = array(
            'get'       => stripslashes_deep($_GET),
            'post'      => stripslashes_deep($_POST),
            'request'   => stripslashes_deep($_REQUEST)
        );
    }

    /**
     * Automatically switch the correct get or post for logic
     */
    public function render(){
        global $wpdb;
        ArevicoSQA::isPost() ? $this->post() : $this->get();
    }

    public function getVar($path, $default = '' ){
        return ArevicoSQA::oVal($path, $this->_request_vars['get'], $default );
    }

    public function postVar($path = '', $default = '' ){
        return ArevicoSQA::oVal($path, $this->_request_vars['post'], $default );

    }
    
    public function requestVar($path, $default = '' ){
        return ArevicoSQA::oVal($path, $this->_request_vars['request'], $default );

    }

    public function verifyCsrf(){
        return wp_verify_nonce($this->requestVar('_arevico_actions', null), -1 ) !== false;
    }

    /**
     * Proxy Function for
     * ArevicoRegistry::loadClas
     */
    public function loadClass($classInfo, $type = ArevicoRegistry::CLASS_CONTROLLER){
        return $this->getRegistry()->loadClass($classInfo, $type);
    }

}

} // End Class Exists Check