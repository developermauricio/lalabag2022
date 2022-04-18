<?php

if ( ! function_exists( 'elaine_edge_get_hide_dep_for_top_header_area_meta_boxes' ) ) {
	function elaine_edge_get_hide_dep_for_top_header_area_meta_boxes() {
		$hide_dep_options = apply_filters( 'elaine_edge_filter_top_header_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'elaine_edge_header_top_area_meta_options_map' ) ) {
	function elaine_edge_header_top_area_meta_options_map( $header_meta_box ) {
		$hide_dep_options = elaine_edge_get_hide_dep_for_top_header_area_meta_boxes();
		
		$top_header_container = elaine_edge_add_admin_container_no_style(
			array(
				'type'            => 'container',
				'name'            => 'top_header_container',
				'parent'          => $header_meta_box,
				'dependency' => array(
					'hide' => array(
						'edgtf_header_type_meta'  => $hide_dep_options
					)
				)
			)
		);
		
		elaine_edge_add_admin_section_title(
			array(
				'parent' => $top_header_container,
				'name'   => 'top_area_style',
				'title'  => esc_html__( 'Top Area', 'elaine' )
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_top_bar_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Header Top Bar', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show header top bar area', 'elaine' ),
				'parent'        => $top_header_container,
				'options'       => elaine_edge_get_yes_no_select_array(),
			)
		);
		
		$top_bar_container = elaine_edge_add_admin_container_no_style(
			array(
				'name'            => 'top_bar_container_no_style',
				'parent'          => $top_header_container,
				'dependency' => array(
					'show' => array(
						'edgtf_top_bar_meta' => 'yes'
					)
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_top_bar_in_grid_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Top Bar In Grid', 'elaine' ),
				'description'   => esc_html__( 'Set top bar content to be in grid', 'elaine' ),
				'parent'        => $top_bar_container,
				'default_value' => '',
				'options'       => elaine_edge_get_yes_no_select_array()
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'   => 'edgtf_top_bar_background_color_meta',
				'type'   => 'color',
				'label'  => esc_html__( 'Top Bar Background Color', 'elaine' ),
				'parent' => $top_bar_container
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_top_bar_background_transparency_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Top Bar Background Color Transparency', 'elaine' ),
				'description' => esc_html__( 'Set top bar background color transparenct. Value should be between 0 and 1', 'elaine' ),
				'parent'      => $top_bar_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_top_bar_border_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Top Bar Border', 'elaine' ),
				'description'   => esc_html__( 'Set border on top bar', 'elaine' ),
				'parent'        => $top_bar_container,
				'default_value' => '',
				'options'       => elaine_edge_get_yes_no_select_array()
			)
		);
		
		$top_bar_border_container = elaine_edge_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'top_bar_border_container',
				'parent'          => $top_bar_container,
				'dependency' => array(
					'show' => array(
						'edgtf_top_bar_border_meta' => 'yes'
					)
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_top_bar_border_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Border Color', 'elaine' ),
				'description' => esc_html__( 'Choose color for top bar border', 'elaine' ),
				'parent'      => $top_bar_border_container
			)
		);
	}
	
	add_action( 'elaine_edge_action_additional_header_area_meta_boxes_map', 'elaine_edge_header_top_area_meta_options_map', 10, 1 );
}