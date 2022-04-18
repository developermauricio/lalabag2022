<?php

if ( ! function_exists( 'elaine_core_map_testimonials_meta' ) ) {
	function elaine_core_map_testimonials_meta() {
		$testimonial_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'testimonials' ),
				'title' => esc_html__( 'Testimonial', 'elaine-core' ),
				'name'  => 'testimonial_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_testimonial_title',
				'type'        => 'text',
				'label'       => esc_html__( 'Title', 'elaine-core' ),
				'description' => esc_html__( 'Enter testimonial title', 'elaine-core' ),
				'parent'      => $testimonial_meta_box,
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_testimonial_text',
				'type'        => 'text',
				'label'       => esc_html__( 'Text', 'elaine-core' ),
				'description' => esc_html__( 'Enter testimonial text', 'elaine-core' ),
				'parent'      => $testimonial_meta_box,
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_testimonial_author',
				'type'        => 'text',
				'label'       => esc_html__( 'Author', 'elaine-core' ),
				'description' => esc_html__( 'Enter author name', 'elaine-core' ),
				'parent'      => $testimonial_meta_box,
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_testimonial_author_position',
				'type'        => 'text',
				'label'       => esc_html__( 'Author Position', 'elaine-core' ),
				'description' => esc_html__( 'Enter author job position', 'elaine-core' ),
				'parent'      => $testimonial_meta_box,
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_core_map_testimonials_meta', 95 );
}