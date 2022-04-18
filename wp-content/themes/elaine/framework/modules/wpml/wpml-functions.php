<?php

if ( ! function_exists( 'elaine_edge_disable_wpml_css' ) ) {
	function elaine_edge_disable_wpml_css() {
		define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );
	}
	
	add_action( 'after_setup_theme', 'elaine_edge_disable_wpml_css' );
}