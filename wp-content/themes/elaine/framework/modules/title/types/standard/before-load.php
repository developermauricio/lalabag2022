<?php

if ( ! function_exists( 'elaine_edge_set_hide_dep_options_title_standard' ) ) {
	/**
	 * This function is used to hide all containers/panels for admin options when this title type is selected
	 */
	function elaine_edge_set_hide_dep_options_title_standard( $hide_dep_options ) {
		$hide_dep_options[] = 'standard';
		
		return $hide_dep_options;
	}
	
	// hide breadcrumbs meta
	add_filter( 'elaine_edge_filter_breadcrumbs_title_hide_meta_boxes', 'elaine_edge_set_hide_dep_options_title_standard' );
}