<?php
/**
 * 
 */
class arvalRedirectModel extends ArevicoDBModel
{

	protected $_fillable 	= array('slug', 'name', 'match_type', 'encode');
	protected $_bools 		= array('encode');

	function __construct( $reg )
	{
		parent::__construct( $reg );
		$this->_db 	= new ArevicoDB( $reg );
		$this->_db->setTable('redirects', false);
	}
}
