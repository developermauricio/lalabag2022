<?php

if ( ! function_exists( 'elaine_edge_register_woocommerce_dropdown_cart_widget' ) ) {
	/**
	 * Function that register dropdown cart widget
	 */
	function elaine_edge_register_woocommerce_dropdown_cart_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassWoocommerceDropdownCart';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_woocommerce_dropdown_cart_widget' );
}

if ( ! function_exists( 'elaine_edge_get_dropdown_cart_icon_class' ) ) {
	/**
	 * Returns dropdow cart icon class
	 */
	function elaine_edge_get_dropdown_cart_icon_class() {
		$classes = array(
			'edgtf-header-cart'
		);
		
		$classes[] = elaine_edge_get_icon_sources_class( 'dropdown_cart', 'edgtf-header-cart' );
		
		return $classes;
	}
}