<?php

if ( ! function_exists( 'elaine_edge_register_header_standard_type' ) ) {
	/**
	 * This function is used to register header type class for header factory file
	 */
	function elaine_edge_register_header_standard_type( $header_types ) {
		$header_type = array(
			'header-standard' => 'ElaineEdgeNamespace\Modules\Header\Types\HeaderStandard'
		);
		
		$header_types = array_merge( $header_types, $header_type );
		
		return $header_types;
	}
}

if ( ! function_exists( 'elaine_edge_init_register_header_standard_type' ) ) {
	/**
	 * This function is used to wait header-function.php file to init header object and then to init hook registration function above
	 */
	function elaine_edge_init_register_header_standard_type() {
		add_filter( 'elaine_edge_filter_register_header_type_class', 'elaine_edge_register_header_standard_type' );
	}
	
	add_action( 'elaine_edge_action_before_header_function_init', 'elaine_edge_init_register_header_standard_type' );
}