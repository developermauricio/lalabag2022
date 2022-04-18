<?php

if ( ! function_exists( 'elaine_edge_map_footer_meta' ) ) {
	function elaine_edge_map_footer_meta() {
		
		$footer_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => apply_filters( 'elaine_edge_filter_set_scope_for_meta_boxes', array( 'page', 'post' ), 'footer_meta' ),
				'title' => esc_html__( 'Footer', 'elaine' ),
				'name'  => 'footer_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_disable_footer_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Disable Footer for this Page', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will hide footer on this page', 'elaine' ),
				'options'       => elaine_edge_get_yes_no_select_array(),
				'parent'        => $footer_meta_box
			)
		);
		
		$show_footer_meta_container = elaine_edge_add_admin_container(
			array(
				'name'       => 'edgtf_show_footer_meta_container',
				'parent'     => $footer_meta_box,
				'dependency' => array(
					'hide' => array(
						'edgtf_disable_footer_meta' => 'yes'
					)
				)
			)
		);
		
			elaine_edge_create_meta_box_field(
				array(
					'name'          => 'edgtf_footer_in_grid_meta',
					'type'          => 'select',
					'default_value' => '',
					'label'         => esc_html__( 'Footer in Grid', 'elaine' ),
					'description'   => esc_html__( 'Enabling this option will place Footer content in grid', 'elaine' ),
					'options'       => elaine_edge_get_yes_no_select_array(),
					'parent'        => $show_footer_meta_container
				)
			);
			
			elaine_edge_create_meta_box_field(
				array(
					'name'          => 'edgtf_uncovering_footer_meta',
					'type'          => 'select',
					'default_value' => '',
					'label'         => esc_html__( 'Uncovering Footer', 'elaine' ),
					'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'elaine' ),
					'options'       => elaine_edge_get_yes_no_select_array(),
					'parent'        => $show_footer_meta_container
				)
			);
		
			elaine_edge_create_meta_box_field(
				array(
					'name'          => 'edgtf_show_footer_top_meta',
					'type'          => 'select',
					'default_value' => '',
					'label'         => esc_html__( 'Show Footer Top', 'elaine' ),
					'description'   => esc_html__( 'Enabling this option will show Footer Top area', 'elaine' ),
					'options'       => elaine_edge_get_yes_no_select_array(),
					'parent'        => $show_footer_meta_container
				)
			);
		
			elaine_edge_create_meta_box_field(
				array(
					'name'        => 'edgtf_footer_top_background_color_meta',
					'type'        => 'color',
					'label'       => esc_html__( 'Footer Top Background Color', 'elaine' ),
					'description' => esc_html__( 'Set background color for top footer area', 'elaine' ),
					'parent'      => $show_footer_meta_container,
					'dependency' => array(
						'show' => array(
							'edgtf_show_footer_top_meta' => array( '', 'yes' )
						)
					)
				)
			);
			
			elaine_edge_create_meta_box_field(
				array(
					'name'          => 'edgtf_show_footer_bottom_meta',
					'type'          => 'select',
					'default_value' => '',
					'label'         => esc_html__( 'Show Footer Bottom', 'elaine' ),
					'description'   => esc_html__( 'Enabling this option will show Footer Bottom area', 'elaine' ),
					'options'       => elaine_edge_get_yes_no_select_array(),
					'parent'        => $show_footer_meta_container
				)
			);
		
			elaine_edge_create_meta_box_field(
				array(
					'name'        => 'edgtf_footer_bottom_background_color_meta',
					'type'        => 'color',
					'label'       => esc_html__( 'Footer Bottom Background Color', 'elaine' ),
					'description' => esc_html__( 'Set background color for bottom footer area', 'elaine' ),
					'parent'      => $show_footer_meta_container,
					'dependency' => array(
						'show' => array(
							'edgtf_show_footer_bottom_meta' => array( '', 'yes' )
						)
					)
				)
			);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_footer_meta', 70 );
}