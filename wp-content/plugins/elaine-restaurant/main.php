<?php
/*
Plugin Name: Elaine Restaurant
Description: Plugin that adds features to our theme
Author: Edge Themes
Version: 1.0
*/

include_once 'load.php';

add_action( 'after_setup_theme', array( ElaineRestaurant\CPT\PostTypesRegister::getInstance(), 'register' ) );

if ( ! function_exists( 'elaine_restaurant_load_assets' ) ) {
	function elaine_restaurant_load_assets() {
		wp_enqueue_style( 'elaine-restaurant-style', plugins_url( '/assets/css/restaurant.min.css', __FILE__ ), array(), '' );
		
		if ( function_exists( 'elaine_edge_is_responsive_on' ) && elaine_edge_is_responsive_on() ) {
			wp_enqueue_style( 'elaine-restaurant-responsive-style', plugins_url( '/assets/css/restaurant-responsive.min.css', __FILE__ ), array(), '' );
		}
		
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'elaine-restaurant-script', plugins_url( '/assets/js/restaurant.min.js', __FILE__ ), array( 'jquery' ), '', true );
	}
	
	add_action( 'wp_enqueue_scripts', 'elaine_restaurant_load_assets' );
}

if ( ! function_exists( 'elaine_restaurant_style_dynamics_deps' ) ) {
	function elaine_restaurant_style_dynamics_deps( $deps ) {
		$style_dynamic_deps_array = array();
		$style_dynamic_deps_array[] = 'elaine-restaurant-style';
		
		if ( function_exists( 'elaine_edge_is_responsive_on' ) && elaine_edge_is_responsive_on() ) {
			$style_dynamic_deps_array[] = 'elaine-restaurant-responsive-style';
		}
		
		return array_merge( $deps, $style_dynamic_deps_array );
	}
	
	add_filter( 'elaine_edge_filter_style_dynamic_deps', 'elaine_restaurant_style_dynamics_deps' );
}