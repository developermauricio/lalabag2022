<?php

if ( ! function_exists( 'elaine_edge_register_sidearea_opener_widget' ) ) {
	/**
	 * Function that register sidearea opener widget
	 */
	function elaine_edge_register_sidearea_opener_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassSideAreaOpener';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_sidearea_opener_widget' );
}