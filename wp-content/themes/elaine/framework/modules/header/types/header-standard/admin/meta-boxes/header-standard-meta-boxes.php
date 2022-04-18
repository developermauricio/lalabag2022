<?php

if ( ! function_exists( 'elaine_edge_get_hide_dep_for_header_standard_meta_boxes' ) ) {
	function elaine_edge_get_hide_dep_for_header_standard_meta_boxes() {
		$hide_dep_options = apply_filters( 'elaine_edge_filter_header_standard_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'elaine_edge_header_standard_meta_map' ) ) {
	function elaine_edge_header_standard_meta_map( $parent ) {
		$hide_dep_options = elaine_edge_get_hide_dep_for_header_standard_meta_boxes();
		
		elaine_edge_create_meta_box_field(
			array(
				'parent'          => $parent,
				'type'            => 'select',
				'name'            => 'edgtf_set_menu_area_position_meta',
				'default_value'   => '',
				'label'           => esc_html__( 'Choose Menu Area Position', 'elaine' ),
				'description'     => esc_html__( 'Select menu area position in your header', 'elaine' ),
				'options'         => array(
					''       => esc_html__( 'Default', 'elaine' ),
					'left'   => esc_html__( 'Left', 'elaine' ),
					'right'  => esc_html__( 'Right', 'elaine' ),
					'center' => esc_html__( 'Center', 'elaine' )
				),
				'dependency' => array(
					'hide' => array(
						'edgtf_header_type_meta'  => $hide_dep_options
					)
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_additional_header_area_meta_boxes_map', 'elaine_edge_header_standard_meta_map' );
}