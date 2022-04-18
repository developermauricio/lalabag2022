<?php

if ( ! function_exists( 'elaine_edge_register_button_widget' ) ) {
	/**
	 * Function that register button widget
	 */
	function elaine_edge_register_button_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassButtonWidget';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_button_widget' );
}