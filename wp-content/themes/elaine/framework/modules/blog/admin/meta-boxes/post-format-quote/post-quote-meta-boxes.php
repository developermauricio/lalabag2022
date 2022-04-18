<?php

if ( ! function_exists( 'elaine_edge_map_post_quote_meta' ) ) {
	function elaine_edge_map_post_quote_meta() {
		$quote_post_format_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Quote Post Format', 'elaine' ),
				'name'  => 'post_format_quote_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_post_quote_text_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Quote Text', 'elaine' ),
				'description' => esc_html__( 'Enter Quote text', 'elaine' ),
				'parent'      => $quote_post_format_meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_post_quote_author_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Quote Author', 'elaine' ),
				'description' => esc_html__( 'Enter Quote author', 'elaine' ),
				'parent'      => $quote_post_format_meta_box
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_post_quote_meta', 25 );
}