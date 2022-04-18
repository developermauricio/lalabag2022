<?php

if ( ! function_exists( 'elaine_edge_register_header_minimal_type' ) ) {
	/**
	 * This function is used to register header type class for header factory file
	 */
	function elaine_edge_register_header_minimal_type( $header_types ) {
		$header_type = array(
			'header-minimal' => 'ElaineEdgeNamespace\Modules\Header\Types\HeaderMinimal'
		);
		
		$header_types = array_merge( $header_types, $header_type );
		
		return $header_types;
	}
}

if ( ! function_exists( 'elaine_edge_init_register_header_minimal_type' ) ) {
	/**
	 * This function is used to wait header-function.php file to init header object and then to init hook registration function above
	 */
	function elaine_edge_init_register_header_minimal_type() {
		add_filter( 'elaine_edge_filter_register_header_type_class', 'elaine_edge_register_header_minimal_type' );
	}
	
	add_action( 'elaine_edge_action_before_header_function_init', 'elaine_edge_init_register_header_minimal_type' );
}

if ( ! function_exists( 'elaine_edge_include_header_minimal_full_screen_menu' ) ) {
	/**
	 * Registers additional menu navigation for theme
	 */
	function elaine_edge_include_header_minimal_full_screen_menu( $menus ) {
		$menus['popup-navigation'] = esc_html__( 'Full Screen Navigation', 'elaine' );
		
		return $menus;
	}
	
	if ( elaine_edge_check_is_header_type_enabled( 'header-minimal' ) ) {
		add_filter( 'elaine_edge_filter_register_headers_menu', 'elaine_edge_include_header_minimal_full_screen_menu' );
	}
}

if ( ! function_exists( 'elaine_edge_get_fullscreen_menu_icon_class' ) ) {
	/**
	 * Loads full screen menu icon class
	 */
	function elaine_edge_get_fullscreen_menu_icon_class() {
		$classes = array(
			'edgtf-fullscreen-menu-opener'
		);
		
		$classes[] = elaine_edge_get_icon_sources_class( 'fullscreen_menu', 'edgtf-fullscreen-menu-opener' );
		
		return $classes;
	}
}