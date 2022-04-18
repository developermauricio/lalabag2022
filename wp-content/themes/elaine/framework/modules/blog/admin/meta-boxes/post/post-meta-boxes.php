<?php

/*** Post Settings ***/

if ( ! function_exists( 'elaine_edge_map_post_meta' ) ) {
	function elaine_edge_map_post_meta() {
		
		$post_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Post', 'elaine' ),
				'name'  => 'post-meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_show_title_area_blog_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show title area on your single post page', 'elaine' ),
				'parent'        => $post_meta_box,
				'options'       => elaine_edge_get_yes_no_select_array()
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_blog_single_sidebar_layout_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout', 'elaine' ),
				'description'   => esc_html__( 'Choose a sidebar layout for Blog single page', 'elaine' ),
				'default_value' => '',
				'parent'        => $post_meta_box,
                'options'       => elaine_edge_get_custom_sidebars_options( true )
			)
		);
		
		$elaine_custom_sidebars = elaine_edge_get_custom_sidebars();
		if ( count( $elaine_custom_sidebars ) > 0 ) {
			elaine_edge_create_meta_box_field( array(
				'name'        => 'edgtf_blog_single_custom_sidebar_area_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Sidebar to Display', 'elaine' ),
				'description' => esc_html__( 'Choose a sidebar to display on Blog single page. Default sidebar is "Sidebar"', 'elaine' ),
				'parent'      => $post_meta_box,
				'options'     => elaine_edge_get_custom_sidebars(),
				'args' => array(
					'select2' => true
				)
			) );
		}
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_blog_list_featured_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Blog List Image', 'elaine' ),
				'description' => esc_html__( 'Choose an Image for displaying in blog list. If not uploaded, featured image will be shown.', 'elaine' ),
				'parent'      => $post_meta_box
			)
		);

		do_action('elaine_edge_action_blog_post_meta', $post_meta_box);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_post_meta', 20 );
}
