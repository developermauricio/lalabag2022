<?php

if ( ! function_exists( 'elaine_edge_register_image_gallery_widget' ) ) {
	/**
	 * Function that register image gallery widget
	 */
	function elaine_edge_register_image_gallery_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassImageGalleryWidget';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_image_gallery_widget' );
}