<?php

/*** Child Theme Function  ***/

if ( ! function_exists( 'elaine_edge_child_theme_enqueue_scripts' ) ) {
	function elaine_edge_child_theme_enqueue_scripts() {
		$parent_style = 'elaine-edge-default-style';
		
		wp_enqueue_style( 'elaine-edge-child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
	}
	
	add_action( 'wp_enqueue_scripts', 'elaine_edge_child_theme_enqueue_scripts' );
}