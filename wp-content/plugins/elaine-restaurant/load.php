<?php

include_once 'const.php';

//load lib
include_once 'lib/helpers-functions.php';
require_once 'lib/shortcode-interface.php';
require_once 'lib/shortcode-loader.php';
require_once 'lib/shortcode-functions.php';

//load post-post-types
require_once 'lib/post-type-interface.php';
require_once 'post-types/post-types-functions.php';
require_once 'post-types/post-types-register.php'; //this has to be loaded last

//load admin
if ( ! function_exists( 'elaine_restaurant_load_admin' ) ) {
	function elaine_restaurant_load_admin() {
		require_once 'admin/options/map.php';
	}
	
	add_action( 'elaine_edge_action_before_options_map', 'elaine_restaurant_load_admin' );
}

//load custom styles
if ( ! function_exists( 'elaine_restaurant_load_custom_styles' ) ) {
	function elaine_restaurant_load_custom_styles() {
		require_once 'assets/custom-styles/restaurant.php';
	}
	
	add_action( 'after_setup_theme', 'elaine_restaurant_load_custom_styles' );
}