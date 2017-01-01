<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://borayalcin.me
 * @since             1.0.0
 * @package           Var_Dumper
 *
 Plugin Name:       VarDumper
 Plugin URI:        http://borayalcin.me
 Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 Version:           1.0.2
 Author:            Bora Yalcin
 Author URI:        http://borayalcin.me
 License:           GPL-2.0+
 License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 Text Domain:       var-dumper
 Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}




/**
* The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-var-dumper.php';

function run_var_dumper() {

    $plugin = new Var_Dumper();
    $plugin->run();

}
run_var_dumper();