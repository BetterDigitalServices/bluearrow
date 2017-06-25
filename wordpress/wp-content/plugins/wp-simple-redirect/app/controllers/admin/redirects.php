<?php
/**
 * 
 */
class arvalRedirectsController extends ArevicoController
{
	protected $_redirects = null;
	/**
	 *
	 */
	public function render(){
		$table 	= $this->loadClass('admin.tables.redirects', ArevicoRegistry::CLASS_TABLE);
		$view 	= $this->makeView('admin.redirects');

		$redirects = $this->_redirects->all();
		$table 	= new $table->className($redirects,'link', 'redirects');
	
		$view->with(array(
			'globalOptions'	 => get_option( 'arval_sl', array()), 
			'redirectsTable' 	 => $table
		));

		return $view->render();
	}

	public function delete(){
		$redirectId 	= $this->getVar('delete');
		$target 		= $this->makeModel('Target');
		$redirects 		= $this->_redirects;

		$target->delete($redirectId);
		$redirects->delete($redirectId);
	}

	/**
	 *
	 */
	function __construct( $app )
	{
		parent::__construct($app);
		$this->_redirects = $this->makeModel('Redirect');

		if ($this->getVar('delete', null) !== null && $this->verifyCsrf() )
			$this->delete();		
	}
}
