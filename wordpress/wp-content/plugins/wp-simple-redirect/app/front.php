<?php
/**
 * The main Front-end part of the application
 */
class arvalAppFront extends ArevicoAppFront{
	
	public function __construct( $reg ){
		parent::__construct( $reg );
		$this->addAction('parse_request', 'front.route@route');

	}

}