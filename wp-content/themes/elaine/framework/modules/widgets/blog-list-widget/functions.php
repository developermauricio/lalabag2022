<?php

if ( ! function_exists( 'elaine_edge_register_blog_list_widget' ) ) {
	/**
	 * Function that register blog list widget
	 */
	function elaine_edge_register_blog_list_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassBlogListWidget';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_blog_list_widget' );
}