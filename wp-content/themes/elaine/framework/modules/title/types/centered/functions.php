<?php

if ( ! function_exists( 'elaine_edge_set_title_centered_type_for_options' ) ) {
	/**
	 * This function set centered title type value for title options map and meta boxes
	 */
	function elaine_edge_set_title_centered_type_for_options( $type ) {
		$type['centered'] = esc_html__( 'Centered', 'elaine' );
		
		return $type;
	}
	
	add_filter( 'elaine_edge_filter_title_type_global_option', 'elaine_edge_set_title_centered_type_for_options' );
	add_filter( 'elaine_edge_filter_title_type_meta_boxes', 'elaine_edge_set_title_centered_type_for_options' );
}