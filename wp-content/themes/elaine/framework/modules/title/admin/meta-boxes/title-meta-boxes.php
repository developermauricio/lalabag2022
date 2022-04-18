<?php

if ( ! function_exists( 'elaine_edge_get_title_types_meta_boxes' ) ) {
	function elaine_edge_get_title_types_meta_boxes() {
		$title_type_options = apply_filters( 'elaine_edge_filter_title_type_meta_boxes', $title_type_options = array( '' => esc_html__( 'Default', 'elaine' ) ) );
		
		return $title_type_options;
	}
}

foreach ( glob( EDGE_FRAMEWORK_MODULES_ROOT_DIR . '/title/types/*/admin/meta-boxes/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if ( ! function_exists( 'elaine_edge_map_title_meta' ) ) {
	function elaine_edge_map_title_meta() {
		$title_type_meta_boxes = elaine_edge_get_title_types_meta_boxes();
		
		$title_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => apply_filters( 'elaine_edge_filter_set_scope_for_meta_boxes', array( 'page', 'post' ), 'title_meta' ),
				'title' => esc_html__( 'Title', 'elaine' ),
				'name'  => 'title_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_show_title_area_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'elaine' ),
				'description'   => esc_html__( 'Disabling this option will turn off page title area', 'elaine' ),
				'parent'        => $title_meta_box,
				'options'       => elaine_edge_get_yes_no_select_array()
			)
		);
		
			$show_title_area_meta_container = elaine_edge_add_admin_container(
				array(
					'parent'          => $title_meta_box,
					'name'            => 'edgtf_show_title_area_meta_container',
					'dependency' => array(
						'hide' => array(
							'edgtf_show_title_area_meta' => 'no'
						)
					)
				)
			);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_title_area_type_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Area Type', 'elaine' ),
						'description'   => esc_html__( 'Choose title type', 'elaine' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => $title_type_meta_boxes
					)
				);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_title_area_in_grid_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Area In Grid', 'elaine' ),
						'description'   => esc_html__( 'Set title area content to be in grid', 'elaine' ),
						'options'       => elaine_edge_get_yes_no_select_array(),
						'parent'        => $show_title_area_meta_container
					)
				);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_title_area_height_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Height', 'elaine' ),
						'description' => esc_html__( 'Set a height for Title Area', 'elaine' ),
						'parent'      => $show_title_area_meta_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px'
						)
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_title_area_background_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Background Color', 'elaine' ),
						'description' => esc_html__( 'Choose a background color for title area', 'elaine' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_title_area_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'elaine' ),
						'description' => esc_html__( 'Choose an Image for title area', 'elaine' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_title_area_background_image_behavior_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Background Image Behavior', 'elaine' ),
						'description'   => esc_html__( 'Choose title area background image behavior', 'elaine' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => array(
							''                    => esc_html__( 'Default', 'elaine' ),
							'hide'                => esc_html__( 'Hide Image', 'elaine' ),
							'responsive'          => esc_html__( 'Enable Responsive Image', 'elaine' ),
							'responsive-disabled' => esc_html__( 'Disable Responsive Image', 'elaine' ),
							'parallax'            => esc_html__( 'Enable Parallax Image', 'elaine' ),
							'parallax-zoom-out'   => esc_html__( 'Enable Parallax With Zoom Out Image', 'elaine' ),
							'parallax-disabled'   => esc_html__( 'Disable Parallax Image', 'elaine' )
						)
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_title_area_vertical_alignment_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Vertical Alignment', 'elaine' ),
						'description'   => esc_html__( 'Specify title area content vertical alignment', 'elaine' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => array(
							''              => esc_html__( 'Default', 'elaine' ),
							'header-bottom' => esc_html__( 'From Bottom of Header', 'elaine' ),
							'window-top'    => esc_html__( 'From Window Top', 'elaine' )
						)
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_title_area_title_tag_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Tag', 'elaine' ),
						'options'       => elaine_edge_get_title_tag( true ),
						'parent'        => $show_title_area_meta_container
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_title_text_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Title Color', 'elaine' ),
						'description' => esc_html__( 'Choose a color for title text', 'elaine' ),
						'parent'      => $show_title_area_meta_container
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_title_area_subtitle_meta',
						'type'          => 'text',
						'default_value' => '',
						'label'         => esc_html__( 'Subtitle Text', 'elaine' ),
						'description'   => esc_html__( 'Enter your subtitle text', 'elaine' ),
						'parent'        => $show_title_area_meta_container,
						'args'          => array(
							'col_width' => 6
						)
					)
				);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_title_area_subtitle_tag_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Subtitle Tag', 'elaine' ),
						'options'       => elaine_edge_get_title_tag( true, array( 'p' => 'p' ) ),
						'parent'        => $show_title_area_meta_container
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_subtitle_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Subtitle Color', 'elaine' ),
						'description' => esc_html__( 'Choose a color for subtitle text', 'elaine' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
		/***************** Additional Title Area Layout - start *****************/
		
		do_action( 'elaine_edge_action_additional_title_area_meta_boxes', $show_title_area_meta_container );
		
		/***************** Additional Title Area Layout - end *****************/
		
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_title_meta', 60 );
}