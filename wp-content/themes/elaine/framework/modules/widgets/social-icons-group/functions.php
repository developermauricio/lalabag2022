<?php

if ( ! function_exists( 'elaine_edge_register_social_icons_widget' ) ) {
	/**
	 * Function that register social icon widget
	 */
	function elaine_edge_register_social_icons_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassClassIconsGroupWidget';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_social_icons_widget' );
}