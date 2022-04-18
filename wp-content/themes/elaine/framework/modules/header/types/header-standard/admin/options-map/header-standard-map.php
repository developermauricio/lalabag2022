<?php

if ( ! function_exists( 'elaine_edge_get_hide_dep_for_header_standard_options' ) ) {
	function elaine_edge_get_hide_dep_for_header_standard_options() {
		$hide_dep_options = apply_filters( 'elaine_edge_filter_header_standard_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'elaine_edge_header_standard_map' ) ) {
	function elaine_edge_header_standard_map( $parent ) {
		$hide_dep_options = elaine_edge_get_hide_dep_for_header_standard_options();
		
		elaine_edge_add_admin_field(
			array(
				'parent'          => $parent,
				'type'            => 'select',
				'name'            => 'set_menu_area_position',
				'default_value'   => 'right',
				'label'           => esc_html__( 'Choose Menu Area Position', 'elaine' ),
				'description'     => esc_html__( 'Select menu area position in your header', 'elaine' ),
				'options'         => array(
					'right'  => esc_html__( 'Right', 'elaine' ),
					'left'   => esc_html__( 'Left', 'elaine' ),
					'center' => esc_html__( 'Center', 'elaine' )
				),
				'dependency' => array(
					'hide' => array(
						'header_options'  => $hide_dep_options
					)
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_additional_header_menu_area_options_map', 'elaine_edge_header_standard_map' );
}