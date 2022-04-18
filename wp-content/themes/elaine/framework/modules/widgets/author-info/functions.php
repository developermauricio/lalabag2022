<?php

if ( ! function_exists( 'elaine_edge_register_author_info_widget' ) ) {
	/**
	 * Function that register author info widget
	 */
	function elaine_edge_register_author_info_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassAuthorInfoWidget';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_author_info_widget' );
}