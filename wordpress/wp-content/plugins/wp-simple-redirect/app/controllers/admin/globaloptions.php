<?php
/**
 * This class renders forms for global options and stores them
 * Options available:
 *		global_prefix 	- The global link prefix for out target urls
 *		global_404 		- If the prefix is set, the prefix matches, but no redirect can be found, use this url
 * 		
 */
class arvalGlobalOptionsController extends ArevicoController
{

	protected $optionName 	= 'arval_sl';
	protected $_error 		= null;

	/**
	 *
	 */
	public function render( ){
		$view = $this->makeView('admin.global-options');

		$o 	= get_option( $this->optionName, array() );

		if ( empty($o['customVariables']) )
			$o['customVariables'] = array( array() );

		$view->with(array(
			'o'			=> $o,
			'update' 	=> $this->_error
		));
		
		$view->render();
	}	

	/**
	 *
	 */
	public function update( ){
		$newSettings = $this->postVar('o', array());
		unset($newSettings['customVariables']['{id}']);
		$newSettings['customVariables'] = array_values( $newSettings['customVariables']);
		update_option($this->optionName, $newSettings );

		return;
	}

	/**
	 *
	 */
	public function __construct( $app ){
		parent::__construct( $app );
		if (ArevicoSQA::isPost() )
			$this->update();
	}
	
}