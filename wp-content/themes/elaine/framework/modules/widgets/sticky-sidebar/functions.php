<?php

if ( ! function_exists( 'elaine_edge_register_sticky_sidebar_widget' ) ) {
	/**
	 * Function that register sticky sidebar widget
	 */
	function elaine_edge_register_sticky_sidebar_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassStickySidebar';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_sticky_sidebar_widget' );
}