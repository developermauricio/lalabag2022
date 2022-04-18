<?php

if ( ! function_exists( 'elaine_edge_map_post_gallery_meta' ) ) {
	
	function elaine_edge_map_post_gallery_meta() {
		$gallery_post_format_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Gallery Post Format', 'elaine' ),
				'name'  => 'post_format_gallery_meta'
			)
		);
		
		elaine_edge_add_multiple_images_field(
			array(
				'name'        => 'edgtf_post_gallery_images_meta',
				'label'       => esc_html__( 'Gallery Images', 'elaine' ),
				'description' => esc_html__( 'Choose your gallery images', 'elaine' ),
				'parent'      => $gallery_post_format_meta_box,
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_post_gallery_meta', 21 );
}
