<?php

if ( ! function_exists( 'elaine_edge_register_recent_posts_widget' ) ) {
	/**
	 * Function that register search opener widget
	 */
	function elaine_edge_register_recent_posts_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassRecentPosts';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_recent_posts_widget' );
}