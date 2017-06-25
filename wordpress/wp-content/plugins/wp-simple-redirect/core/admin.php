<?php
if (!class_exists('ArevicoAppAdmin')){

/**
 * The class will handle all Admin Requests
 *
 * @version 1.0
 * @package Core
 */
class ArevicoAppAdmin extends ArevicoAppCommon{

    protected $_menus       = array();

  /* Interface to add WordPress Menus
     ------------------------------------------------------ */
    public function menu( $callback, $page_title, $menu_title, $menu_slug,  $capability = 'manage_options',  $icon_url = '', $position = null ){
           $classinfo   = $this->getRegistry()->classinfo( $callback , ArevicoRegistry::CLASS_CONTROLLER, 'render');
           $controllerInstance         = get_defined_vars();
           unset($controllerInstance['callback']);
           $this->_menus[]   = $controllerInstance;
	}

     public function subMenu($parent_slug, $callback, $page_title, $menu_title, $menu_slug, $capability = 'manage_options',  $icon_url = '', $position = null ){
          $classinfo   = $this->getRegistry()->classinfo( $callback, ArevicoRegistry::CLASS_CONTROLLER, 'render');
          $controllerInstance         = get_defined_vars();
          unset($controllerInstance['callback']);
          $this->_menus[]   = $controllerInstance;
    }

    /**
	 * Call the reigstered controller
	 * @return void
	 */
	public function renderPage(){
        $menu       = $this->determinePage();
        $classinfo   = $menu['classinfo'];

        $controller = $this->getRegistry()->getInstance('controller', $classinfo->original );
        call_user_func( array($controller, $classinfo->method )) ;
	}

     /* Internal methods
     ------------------------------------------------------ */
    /**
	 * Register all menus
     *
	 * @return void
	 */
	public function addMenus(){
        foreach ($this->_menus as $menu){

            $menu['callback'] = array($this , 'renderPage');

            if (isset($menu['parent_slug'])){
                add_submenu_page($menu['parent_slug'], $menu['page_title'], $menu['menu_title'], $menu['capability'],  $menu['menu_slug'], $menu['callback'] );
            } else{
                add_menu_page($menu['page_title'], $menu['menu_title'], $menu['capability'],  $menu['menu_slug'], $menu['callback'], $menu['icon_url'], $menu['position'] );
            }

        }
	}

     /**
	 * Process the request of an admin page
     *
	 * @return void
	*/
	public function routes(){
		/* make sure that we only execute our code if one of our registered page is loaded */
        $menu = $this->determinePage();

		if ( $menu && !empty($_GET['page'])){
            $className = $menu['classinfo']->className;
            $this->getRegistry()->loadClass( $menu['classinfo']);
            $controllerInstance = new $className( $this ) ;

            $this->getRegistry()->register('controller', $controllerInstance, $menu['classinfo']->original );
            add_action( 'current_screen'	    , array($this , 'routes'));
            add_action( 'admin_enqueue_scripts' , array($controllerInstance  , 'assets')  );
		}

	}

	/**
 	* Determines which page we need to load
     *
	* @param string $_GET['page'] The slug of the page. Is registered before this function is called (guaranteed)
 	*/
	private function determinePage(){
   		if (!isset($_GET['page']))
			return false;

        $page   =  $_GET['page'];

        foreach ($this->_menus as $menu) {
            if (strcasecmp($menu['menu_slug'], $page) === 0 )
                return $menu;
        }

        return false;
	}

    /**
     * Create a new Admin App
     *
     * @param Registry $reg the applications main registry
     */
	function __construct( $reg ){
        parent::__construct( $reg );
        add_action( 'admin_menu' 		, array($this, 'addMenus') );
		add_action( 'current_screen'	, array($this, 'routes'));
	}

}

} // End Class Exists Check