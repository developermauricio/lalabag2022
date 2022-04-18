<?php

if ( ! function_exists( 'elaine_edge_register_separator_widget' ) ) {
	/**
	 * Function that register separator widget
	 */
	function elaine_edge_register_separator_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassSeparatorWidget';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_separator_widget' );
}