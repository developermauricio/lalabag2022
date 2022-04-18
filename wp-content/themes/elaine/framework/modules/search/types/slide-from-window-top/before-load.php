<?php

if ( ! function_exists( 'elaine_edge_set_search_slide_from_wt_global_option' ) ) {
    /**
     * This function set search type value for search options map
     */
    function elaine_edge_set_search_slide_from_wt_global_option( $search_type_options ) {
        $search_type_options['slide-from-window-top'] = esc_html__( 'Slide From Window Top', 'elaine' );

        return $search_type_options;
    }

    add_filter( 'elaine_edge_filter_search_type_global_option', 'elaine_edge_set_search_slide_from_wt_global_option' );
}

if ( ! function_exists( 'elaine_edge_search_in_grid_dependency_slide_from_window_top' ) ) {
	/**
	 * Add dependency for 'search_in_grid' field type
	 */
	function elaine_edge_search_in_grid_dependency_slide_from_window_top($dependency_array) {

		$dependency_array[] = 'slide-from-window-top';

		return $dependency_array;
	}

	add_filter( 'search_in_grid_dependency', 'elaine_edge_search_in_grid_dependency_slide_from_window_top' );
}