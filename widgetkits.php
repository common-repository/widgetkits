<?php 
/*
Plugin Name: Widgetkits For Elementor
Plugin URI: https://github.com/masumskaib396/widgetkits
Description: The Widgetkits is an Elementor helping plugin that will make your designing work easier.
Our specialities are custom CSS, Nested section, Contact form 7, Creative Buttons.
Version: 1.1.1
Author: msakib
Author URI: https://profiles.wordpress.org/msakib/
License: GPLv2 or later
Text Domain: widgetkits
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//Set plugin version constant.
define( 'WIGETKITS_VERSION', '1.1.1');
/* Set constant path to the plugin directory. */
define( 'WIGETKITS_WIDGET', trailingslashit( plugin_dir_path( __FILE__ ) ) );
// Plugin Function Folder Path
define( 'WIGETKITS_WIDGET_INC', plugin_dir_path( __FILE__ ) . 'inc/' );

// Plugin Extensions Folder Path
define( 'WIGETKITS_WIDGET_EXTENSIONS', plugin_dir_path( __FILE__ ) . 'extensions/' );

// Plugin Widget Folder Path
define( 'WIGETKITS_WIDGET_DIR', plugin_dir_path( __FILE__ ) . 'widgets/' );

// Assets Folder URL
define( 'WIGETKITS_ASSETS_PUBLIC', plugins_url( 'assets', __FILE__ ) );

// Assets Folder URL
define( 'WIGETKITS_ASSETS_VERDOR', plugins_url( 'assets/vendor', __FILE__ ) );


require_once( WIGETKITS_WIDGET_INC . 'sidebar-widget-file.php' );
require_once(WIGETKITS_WIDGET_INC . 'helper-function.php');
require_once( WIGETKITS_WIDGET . 'base.php' );

?>
