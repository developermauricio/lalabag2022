<?php

if ( ! function_exists( 'elaine_edge_map_post_video_meta' ) ) {
	function elaine_edge_map_post_video_meta() {
		$video_post_format_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Video Post Format', 'elaine' ),
				'name'  => 'post_format_video_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_video_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Video Type', 'elaine' ),
				'description'   => esc_html__( 'Choose video type', 'elaine' ),
				'parent'        => $video_post_format_meta_box,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Video Service', 'elaine' ),
					'self'            => esc_html__( 'Self Hosted', 'elaine' )
				)
			)
		);
		
		$edgtf_video_embedded_container = elaine_edge_add_admin_container(
			array(
				'parent' => $video_post_format_meta_box,
				'name'   => 'edgtf_video_embedded_container'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_post_video_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video URL', 'elaine' ),
				'description' => esc_html__( 'Enter Video URL', 'elaine' ),
				'parent'      => $edgtf_video_embedded_container,
				'dependency' => array(
					'show' => array(
						'edgtf_video_type_meta' => 'social_networks'
					)
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_post_video_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video MP4', 'elaine' ),
				'description' => esc_html__( 'Enter video URL for MP4 format', 'elaine' ),
				'parent'      => $edgtf_video_embedded_container,
				'dependency' => array(
					'show' => array(
						'edgtf_video_type_meta' => 'self'
					)
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_post_video_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Video Image', 'elaine' ),
				'description' => esc_html__( 'Enter video image', 'elaine' ),
				'parent'      => $edgtf_video_embedded_container,
				'dependency' => array(
					'show' => array(
						'edgtf_video_type_meta' => 'self'
					)
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_post_video_meta', 22 );
}