<?php

if ( ! function_exists( 'elaine_edge_header_types_meta_boxes' ) ) {
	function elaine_edge_header_types_meta_boxes() {
		$header_type_options = apply_filters( 'elaine_edge_filter_header_type_meta_boxes', $header_type_options = array( '' => esc_html__( 'Default', 'elaine' ) ) );
		
		return $header_type_options;
	}
}

if ( ! function_exists( 'elaine_edge_get_hide_dep_for_header_behavior_meta_boxes' ) ) {
	function elaine_edge_get_hide_dep_for_header_behavior_meta_boxes() {
		$hide_dep_options = apply_filters( 'elaine_edge_filter_header_behavior_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

foreach ( glob( EDGE_FRAMEWORK_HEADER_ROOT_DIR . '/admin/meta-boxes/*/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

foreach ( glob( EDGE_FRAMEWORK_HEADER_TYPES_ROOT_DIR . '/*/admin/meta-boxes/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if ( ! function_exists( 'elaine_edge_map_header_meta' ) ) {
	function elaine_edge_map_header_meta() {
		$header_type_meta_boxes              = elaine_edge_header_types_meta_boxes();
		$header_behavior_meta_boxes_hide_dep = elaine_edge_get_hide_dep_for_header_behavior_meta_boxes();
		
		$header_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => apply_filters( 'elaine_edge_filter_set_scope_for_meta_boxes', array( 'page', 'post' ), 'header_meta' ),
				'title' => esc_html__( 'Header', 'elaine' ),
				'name'  => 'header_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_header_type_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Choose Header Type', 'elaine' ),
				'description'   => esc_html__( 'Select header type layout', 'elaine' ),
				'parent'        => $header_meta_box,
				'options'       => $header_type_meta_boxes
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_header_style_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Header Skin', 'elaine' ),
				'description'   => esc_html__( 'Choose a header style to make header elements (logo, main menu, side menu button) in that predefined style', 'elaine' ),
				'parent'        => $header_meta_box,
				'options'       => array(
					''             => esc_html__( 'Default', 'elaine' ),
					'light-header' => esc_html__( 'Light', 'elaine' ),
					'dark-header'  => esc_html__( 'Dark', 'elaine' )
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'parent'          => $header_meta_box,
				'type'            => 'select',
				'name'            => 'edgtf_header_behaviour_meta',
				'default_value'   => '',
				'label'           => esc_html__( 'Choose Header Behaviour', 'elaine' ),
				'description'     => esc_html__( 'Select the behaviour of header when you scroll down to page', 'elaine' ),
				'options'         => array(
					''                                => esc_html__( 'Default', 'elaine' ),
					'fixed-on-scroll'                 => esc_html__( 'Fixed on scroll', 'elaine' ),
					'no-behavior'                     => esc_html__( 'No Behavior', 'elaine' ),
					'sticky-header-on-scroll-up'      => esc_html__( 'Sticky on scroll up', 'elaine' ),
					'sticky-header-on-scroll-down-up' => esc_html__( 'Sticky on scroll up/down', 'elaine' )
				),
				'dependency' => array(
					'hide' => array(
						'edgtf_header_type_meta'  => $header_behavior_meta_boxes_hide_dep
					)
				)
			)
		);
		
		//additional area
		do_action( 'elaine_edge_action_additional_header_area_meta_boxes_map', $header_meta_box );
		
		//top area
		do_action( 'elaine_edge_action_header_top_area_meta_boxes_map', $header_meta_box );
		
		//logo area
		do_action( 'elaine_edge_action_header_logo_area_meta_boxes_map', $header_meta_box );
		
		//menu area
		do_action( 'elaine_edge_action_header_menu_area_meta_boxes_map', $header_meta_box );

		//dropdown
		do_action( 'elaine_edge_action_dropdown_meta_boxes_map', $header_meta_box );

		//widget areaa
		do_action( 'elaine_edge_action_header_widget_areas_meta_boxes_map', $header_meta_box );
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_header_meta', 50 );
}