<?php

if ( ! function_exists( 'elaine_edge_register_icon_widget' ) ) {
	/**
	 * Function that register icon widget
	 */
	function elaine_edge_register_icon_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassIconWidget';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_icon_widget' );
}