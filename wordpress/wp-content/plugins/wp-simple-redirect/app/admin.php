<?php
/**
 * The main back-end part of the application
 */
class arvalAppAdmin extends ArevicoAppAdmin{

	/**
	 * Add all menus
	 */
	public function __construct( $registry ){
		parent::__construct( $registry );
		$this->menu('Admin.GlobalOptions', 'WP Simple Redirects', 'Simple Redirect', 'wp-simple-redirect');
		$this->subMenu('wp-simple-redirect','admin.redirects', 'Redirects', 'Redirects', 'wp-simple-redirect-overview');
		$this->subMenu('wp-simple-redirect','admin.RedirectNew', 'Add New', 'Add New', 'wp-simple-redirect-new');
		$this->subMenu('wp-simple-redirect','admin.Faq',  'Frequently Asked Questions', 'F.A.Q.', 'wp-simple-redirect-faq');

		/* Change the menu name of the first submenu */
		$this->addAction('current_screen', array($this, 'change_sub'), 110 );

	}

	/**
	 * Rename the sub-level duplicate of a top level menu item
	 */
	public function change_sub(){
		global $submenu;
		if (isset($submenu['wp-simple-redirect'], $submenu['wp-simple-redirect'][0], $submenu['wp-simple-redirect'][0][0]))
			$submenu['wp-simple-redirect'][0][0]='Settings';
	}

}