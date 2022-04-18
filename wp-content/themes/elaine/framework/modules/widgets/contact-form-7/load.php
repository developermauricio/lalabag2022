<?php

if ( elaine_edge_contact_form_7_installed() ) {
	include_once EDGE_FRAMEWORK_MODULES_ROOT_DIR . '/widgets/contact-form-7/contact-form-7.php';
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_cf7_widget' );
}

if ( ! function_exists( 'elaine_edge_register_cf7_widget' ) ) {
	/**
	 * Function that register cf7 widget
	 */
	function elaine_edge_register_cf7_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassContactForm7Widget';
		
		return $widgets;
	}
}