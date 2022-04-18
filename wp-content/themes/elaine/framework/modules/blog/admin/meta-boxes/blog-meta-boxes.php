<?php

foreach ( glob( EDGE_FRAMEWORK_MODULES_ROOT_DIR . '/blog/admin/meta-boxes/*/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if ( ! function_exists( 'elaine_edge_map_blog_meta' ) ) {
	function elaine_edge_map_blog_meta() {
		$edgtf_blog_categories = array();
		$categories           = get_categories();
		foreach ( $categories as $category ) {
			$edgtf_blog_categories[ $category->slug ] = $category->name;
		}
		
		$blog_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'page' ),
				'title' => esc_html__( 'Blog', 'elaine' ),
				'name'  => 'blog_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_blog_category_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Blog Category', 'elaine' ),
				'description' => esc_html__( 'Choose category of posts to display (leave empty to display all categories)', 'elaine' ),
				'parent'      => $blog_meta_box,
				'options'     => $edgtf_blog_categories
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_show_posts_per_page_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Posts', 'elaine' ),
				'description' => esc_html__( 'Enter the number of posts to display', 'elaine' ),
				'parent'      => $blog_meta_box,
				'options'     => $edgtf_blog_categories,
				'args'        => array(
					'col_width' => 3
				)
			)
		);

		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_blog_pagination_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Pagination Type', 'elaine' ),
				'description'   => esc_html__( 'Choose a pagination layout for Blog Lists', 'elaine' ),
				'parent'        => $blog_meta_box,
				'default_value' => '',
				'options'       => array(
					''                => esc_html__( 'Default', 'elaine' ),
					'standard'        => esc_html__( 'Standard', 'elaine' ),
					'load-more'       => esc_html__( 'Load More', 'elaine' ),
					'infinite-scroll' => esc_html__( 'Infinite Scroll', 'elaine' ),
					'no-pagination'   => esc_html__( 'No Pagination', 'elaine' )
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'type'          => 'text',
				'name'          => 'edgtf_number_of_chars_meta',
				'default_value' => '',
				'label'         => esc_html__( 'Number of Words in Excerpt', 'elaine' ),
				'description'   => esc_html__( 'Enter a number of words in excerpt (article summary). Default value is 40', 'elaine' ),
				'parent'        => $blog_meta_box,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_blog_meta', 30 );
}