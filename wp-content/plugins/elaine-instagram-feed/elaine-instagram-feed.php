<?php
/*
Plugin Name: Elaine Instagram Feed
Description: Plugin that adds Instagram feed functionality to our theme
Author: Edge Themes
Version: 1.0
*/
define('ELAINE_INSTAGRAM_FEED_VERSION', '1.0');
define('ELAINE_INSTAGRAM_ABS_PATH', dirname(__FILE__));
define('ELAINE_INSTAGRAM_REL_PATH', dirname(plugin_basename(__FILE__ )));
define( 'ELAINE_INSTAGRAM_URL_PATH', plugin_dir_url( __FILE__ ) );
define( 'ELAINE_INSTAGRAM_ASSETS_PATH', ELAINE_INSTAGRAM_ABS_PATH . '/assets' );
define( 'ELAINE_INSTAGRAM_ASSETS_URL_PATH', ELAINE_INSTAGRAM_URL_PATH . 'assets' );
define( 'ELAINE_INSTAGRAM_SHORTCODES_PATH', ELAINE_INSTAGRAM_ABS_PATH . '/shortcodes' );
define( 'ELAINE_INSTAGRAM_SHORTCODES_URL_PATH', ELAINE_INSTAGRAM_URL_PATH . 'shortcodes' );

include_once 'load.php';

if ( ! function_exists( 'elaine_instagram_theme_installed' ) ) {
    /**
     * Checks whether theme is installed or not
     * @return bool
     */
    function elaine_instagram_theme_installed() {
        return defined( 'EDGE_ROOT' );
    }
}

if ( ! function_exists( 'elaine_instagram_feed_text_domain' ) ) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function elaine_instagram_feed_text_domain() {
		load_plugin_textdomain( 'elaine-instagram-feed', false, ELAINE_INSTAGRAM_REL_PATH . '/languages' );
	}
	
	add_action( 'plugins_loaded', 'elaine_instagram_feed_text_domain' );
}