<?php

if ( ! function_exists( 'elaine_edge_logo_meta_box_map' ) ) {
	function elaine_edge_logo_meta_box_map() {
		
		$logo_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => apply_filters( 'elaine_edge_filter_set_scope_for_meta_boxes', array( 'page', 'post' ), 'logo_meta' ),
				'title' => esc_html__( 'Logo', 'elaine' ),
				'name'  => 'logo_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_logo_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Default', 'elaine' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'elaine' ),
				'parent'      => $logo_meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_logo_image_dark_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Dark', 'elaine' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'elaine' ),
				'parent'      => $logo_meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_logo_image_light_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Light', 'elaine' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'elaine' ),
				'parent'      => $logo_meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_logo_image_sticky_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Sticky', 'elaine' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'elaine' ),
				'parent'      => $logo_meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_logo_image_mobile_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Mobile', 'elaine' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'elaine' ),
				'parent'      => $logo_meta_box
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_logo_meta_box_map', 47 );
}