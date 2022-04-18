<?php
/**
 * Plugin Name: video player gallery
 * Plugin URI: https://wponlinehelp.com/plugins/
 * Version: 1.2
 * Description: simple to create and show Video player using Youtube, vimeo, and HTML5 video with zoom lightbox with fully responsive to display Wordpress site. place  your website using shortcode.
 * Text Domain: video-player
 * Domain Path: /languages/
 * Author: pareshpachani007
 * Author URI: https://wponlinehelp.com
 * @package WordPress
 * @author pareshpachani007
 */
if ( ! defined( 'ABSPATH' ) ) exit;
define( 'WP_VPG_VERSION', '1.2' ); // Version of plugin
define( 'WP_VPG_DIR', dirname( __FILE__ ) ); // Plugin dir path
define( 'WP_VPG_URL', plugin_dir_url( __FILE__ ) ); // Plugin full url
define( 'WP_VPG_POST_TYPE', 'vpg_video' ); //  post type name
define( 'WP_VPG_CAT', 'vpg_cat' ); //  category name
/**
 * Function to load plugin text domain
 * 
 * @package video player gallery
 * @since 1.0
 */ 
 
add_action('plugins_loaded', 'wp_vpg_textdomain');
function wp_vpg_textdomain() {
	load_plugin_textdomain( 'vpg-video-player', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
} 
/**
 * Function to create category shortcode
 * 
 * @package video player gallery
 * @since 1.0
 */
add_filter("manage_vpg_cat_custom_column", 'vpg_cat_columns', 10, 3);
add_filter("manage_edit-vpg_cat_columns", 'vpg_cat_manage_columns'); 
function vpg_cat_manage_columns($columns) {
	$new_columns['video_shortcode'] = __( 'Category Shortcode', 'video-player' );
	$columns = vpg_add_array( $columns, $new_columns, 2 );
	return $columns;
}
function vpg_cat_columns($out, $column_name, $theme_id) {
	switch ($column_name) {
		case 'video_shortcode':
			echo '[vpg_grid video_cat="' . $theme_id. '"]'.'</br>';
			echo '[vpg_slider video_cat="' . $theme_id. '"]'.'</br>';
			echo '[vpg_playlist video_cat="' . $theme_id. '"]'.'</br>';
			break;
	}
	return $out;
}
//For Post Ragitration
require_once( WP_VPG_DIR . '/vpg-includes/vpg-cpt.php' );
// Functions File
require_once( WP_VPG_DIR . '/vpg-includes/vpg-functions.php' );
// For Shortcode create
require_once( WP_VPG_DIR . '/vpg-shortcode/grid-shortcode.php' ); 
require_once( WP_VPG_DIR . '/vpg-shortcode/slider-shortcode.php' );
require_once( WP_VPG_DIR . '/vpg-shortcode/slider-play-list-shortcode.php');
// For post meta box
require_once( WP_VPG_DIR . '/vpg-includes/post_metabox.php' );
// Load admin files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	include_once( WP_VPG_DIR . '/vpg-includes/admin/vpg-help.php' );	
}