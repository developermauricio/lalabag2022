<?php

if ( ! function_exists( 'elaine_edge_register_custom_font_widget' ) ) {
	/**
	 * Function that register custom font widget
	 */
	function elaine_edge_register_custom_font_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassCustomFontWidget';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_custom_font_widget' );
}