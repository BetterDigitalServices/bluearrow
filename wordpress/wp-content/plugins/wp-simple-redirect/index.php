<?php
/*
Plugin Name: WP Simple Redirect
Plugin URI: http://arevico.com/sp-simple-redirect/
Description: Create short links and redirect in your WordPress dashboard, both simple links as well as regular expression matching.
Version: 1.1
Author: Arevico
*/

if (!defined('ABSPATH'))
    die();

/** Require helper classes with a number of functions*/
require 'core/helper/moscow.php';
require 'core/helper/db.php';

/** Require All Model/View/Controller componenets */
require 'core/dbmodel.php';
require 'core/view.php';
require 'core/controller.php';

/** Require the registry (of citizens) which stores all created classes*/
require 'core/registry.php';
require 'core/helper/error.php';
require 'core/helper/updateinfo.php';

/** Common functions our application (admin and front-end) need */
require 'core/common.php';

/* All Application and bootstrap logic goes on beneath. Be mindfull, this is a global scope
--------------------------------------------------------------------*/
$arvalRegistry   = new ArevicoRegistry('arval', dirname(__FILE__) );

// On activation hooks, globals aren't set, so lets check to avoid errors
if (isset($wpdb))
    $arvalRegistry->setDBPrefix( $wpdb->prefix . 'arval_' );

// Bootstrap
// Process all admin requests
if ( is_admin() ){

    /** Require all Class Objects that provide structure to certain information*/
    require 'core/table.php';
    require 'core/helper/paginateinfo.php';

    require 'core/admin.php';
    require 'app/admin.php';
    $admin      = new arvalAppAdmin( $arvalRegistry );

    require 'app/activate.php';
 
    $arvalAppActivate = new arvalAppActivate( $arvalRegistry);
    register_activation_hook(__FILE__, array($arvalAppActivate, 'install') );

 } elseif( !is_admin() ) {
    require 'core/front.php';
    require 'app/front.php';
	$front      = new arvalAppFront( $arvalRegistry );

 }
