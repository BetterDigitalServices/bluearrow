<?php
/**
 * 
 */
class arvalRedirectNewController extends ArevicoController
{
	/** Models */
	protected $_redirects 	= null;
	protected $_target 	= null;

	/**
	 *
	 */
	public function render(){
		$view 				= $this->makeView('admin.redirect-new');
		$target_template 	= array('id' => 'insert-0');
		$currentOptions		= $this->_redirects->issetID() ? $this->_redirects->find($this->_redirects->getID()) : array();

		$targets 			= ( $this->_redirects->issetID() ) ? $this->_target->redirect( $this->_redirects->getID() ) : array();
		
		if ( empty($targets) ){
			$targets = new stdClass();
			$targets->id = 'insert-0';
			$targets = array('insert-0' => $targets);
		}

		$view->with(array(
			'globalOptions'  => get_option('arval_sl'),
			'id' 			 => $this->_redirects->getID(),
			'o'				 => $this->postVar('o', $currentOptions ),
			'targets'		=> $targets
		));
		
		return $view->render();
	}

	/**
	 *
	 */
	function __construct( $app )
	{
		parent::__construct($app);
		$this->_redirects 	= $this->makeModel('Redirect');
		$this->_target 		= $this->makeModel('Target');

		// On an insert action the ID will be null (since it is not set)
		$this->_redirects->setID( $this->requestVar('id', null) );

		// A New Link
		if (ArevicoSQA::isPost() )
			$this->updateLink();

		//	$this->_redirects->redirectInsertSuccess('?page=wp-simple-redirect-new&id=' . $this->_redirects->getID()  );
	}


	/**
	 * Process update requests
	 *
	 */
	public function updateLink(){
		if (!$this->verifyCsrf())
			wp_die('Error! Nonce Token Did Not Match!');
		
		$updateInfo = new ArevicoUpdateInfo('o->target');
		$this->_redirects->update( $this->_redirects->getID(), $this->postVar('o', array() ) );
		$this->_target->update( $this->_redirects->getID(), $updateInfo);
	}
}
