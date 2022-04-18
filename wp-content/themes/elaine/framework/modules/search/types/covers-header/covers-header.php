<?php

if ( ! function_exists( 'elaine_edge_search_body_class' ) ) {
	/**
	 * Function that adds body classes for different search types
	 *
	 * @param $classes array original array of body classes
	 *
	 * @return array modified array of classes
	 */
	function elaine_edge_search_body_class( $classes ) {
		$classes[] = 'edgtf-search-covers-header';
		
		return $classes;
	}
	
	add_filter( 'body_class', 'elaine_edge_search_body_class' );
}

if ( ! function_exists( 'elaine_edge_get_search' ) ) {
	/**
	 * Loads search HTML based on search type option.
	 */
	function elaine_edge_get_search() {
		elaine_edge_load_search_template();
	}
	
	add_action( 'elaine_edge_action_before_page_header_html_close', 'elaine_edge_get_search' );
	add_action( 'elaine_edge_action_before_mobile_header_html_close', 'elaine_edge_get_search' );
}

if ( ! function_exists( 'elaine_edge_load_search_template' ) ) {
	/**
	 * Loads search HTML based on search type option.
	 */
	function elaine_edge_load_search_template() {

		$search_in_grid   = elaine_edge_options()->getOptionValue( 'search_in_grid' ) == 'yes' ? true : false;
		
		$parameters = array(
			'search_in_grid'    		=> $search_in_grid,
			'search_close_icon_class' 	=> elaine_edge_get_search_close_icon_class()
		);
		
		elaine_edge_get_module_template_part( 'types/covers-header/templates/covers-header', 'search', '', $parameters );
	}
}