<?php

if ( ! function_exists( 'elaine_edge_map_post_link_meta' ) ) {
	function elaine_edge_map_post_link_meta() {
		$link_post_format_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Link Post Format', 'elaine' ),
				'name'  => 'post_format_link_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_post_link_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Link', 'elaine' ),
				'description' => esc_html__( 'Enter link', 'elaine' ),
				'parent'      => $link_post_format_meta_box
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_post_link_meta', 24 );
}