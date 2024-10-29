<?php
/*
  Plugin Name: Awesome GST Calculator Widget 
  Description: The plugin displays the GST Calculator widget anywhere you wants with the help of shortcode.
  Tags: quotes, loading quotes,loader
  Author: Ankit Chugh
  License:           GPL-2.0+
  License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
  Version: 1.0.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//Current plugin version.
define('WPGSTCAL_VERSION', '1.0.2');

// Paths
define('WPGSTCAL_PATH', plugin_dir_path( __FILE__ ));
define('WPGSTCAL_DIRNAME', basename( plugin_basename( WPGSTCAL_PATH ) ));
define('WPGSTCAL_PLUGIN_URL', plugins_url() . '/' . WPGSTCAL_DIRNAME);

// Includes
require_once(WPGSTCAL_PATH . '/inc/admin.php');
require_once(WPGSTCAL_PATH . '/inc/general_functions.php');
require_once(WPGSTCAL_PATH . '/inc/widget.php');

//enqueue scripts and styles
function wpgstcal_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_register_script( 'wpgstcal_script', WPGSTCAL_PLUGIN_URL . '/assets/js/script.js' , '', true, '1.0' );
    wp_enqueue_script('wpgstcal_script');
    wp_localize_script( 'wpgstcal_script', 'wpgstcal_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

    wp_enqueue_style( 'wpgstcal_style', WPGSTCAL_PLUGIN_URL . '/assets/css/style.css',true,'1.0','all');

}
add_action('init', 'wpgstcal_enqueue_scripts');


//plugin activation hook
register_activation_hook( __FILE__, 'wpgstcal_plugin_activate' );
function wpgstcal_plugin_activate(){
	  update_option('wpgstcal_enabled',1);
}