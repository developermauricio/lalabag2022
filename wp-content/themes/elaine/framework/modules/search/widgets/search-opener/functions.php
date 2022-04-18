<?php

if ( ! function_exists( 'elaine_edge_register_search_opener_widget' ) ) {
	/**
	 * Function that register search opener widget
	 */
	function elaine_edge_register_search_opener_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassSearchOpener';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_search_opener_widget' );
}