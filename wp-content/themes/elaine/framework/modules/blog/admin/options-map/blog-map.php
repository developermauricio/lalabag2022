<?php

if ( ! function_exists( 'elaine_edge_get_blog_list_types_options' ) ) {
	function elaine_edge_get_blog_list_types_options() {
		$blog_list_type_options = apply_filters( 'elaine_edge_filter_blog_list_type_global_option', $blog_list_type_options = array() );
		
		return $blog_list_type_options;
	}
}

if ( ! function_exists( 'elaine_edge_blog_options_map' ) ) {
	function elaine_edge_blog_options_map() {
		$blog_list_type_options = elaine_edge_get_blog_list_types_options();
		
		elaine_edge_add_admin_page(
			array(
				'slug'  => '_blog_page',
				'title' => esc_html__( 'Blog', 'elaine' ),
				'icon'  => 'fa fa-files-o'
			)
		);
		
		/**
		 * Blog Lists
		 */
		$panel_blog_lists = elaine_edge_add_admin_panel(
			array(
				'page'  => '_blog_page',
				'name'  => 'panel_blog_lists',
				'title' => esc_html__( 'Blog Lists', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'blog_list_grid_space',
				'type'        => 'select',
				'label'       => esc_html__( 'Grid Layout Space', 'elaine' ),
				'description' => esc_html__( 'Choose a space between content layout and sidebar layout for blog post lists. Default value is large', 'elaine' ),
				'options'     => elaine_edge_get_space_between_items_array( true ),
				'parent'      => $panel_blog_lists
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'blog_list_type',
				'type'          => 'select',
				'label'         => esc_html__( 'Blog Layout for Archive Pages', 'elaine' ),
				'description'   => esc_html__( 'Choose a default blog layout for archived blog post lists', 'elaine' ),
				'default_value' => 'standard',
				'parent'        => $panel_blog_lists,
				'options'       => $blog_list_type_options
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'archive_sidebar_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout for Archive Pages', 'elaine' ),
				'description'   => esc_html__( 'Choose a sidebar layout for archived blog post lists', 'elaine' ),
				'default_value' => '',
				'parent'        => $panel_blog_lists,
                'options'       => elaine_edge_get_custom_sidebars_options(),
			)
		);
		
		$elaine_custom_sidebars = elaine_edge_get_custom_sidebars();
		if ( count( $elaine_custom_sidebars ) > 0 ) {
			elaine_edge_add_admin_field(
				array(
					'name'        => 'archive_custom_sidebar_area',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Sidebar to Display for Archive Pages', 'elaine' ),
					'description' => esc_html__( 'Choose a sidebar to display on archived blog post lists. Default sidebar is "Sidebar Page"', 'elaine' ),
					'parent'      => $panel_blog_lists,
					'options'     => elaine_edge_get_custom_sidebars(),
					'args'        => array(
						'select2' => true
					)
				)
			);
		}

		elaine_edge_add_admin_field(
			array(
				'name'          => 'blog_pagination_type',
				'type'          => 'select',
				'label'         => esc_html__( 'Pagination Type', 'elaine' ),
				'description'   => esc_html__( 'Choose a pagination layout for Blog Lists', 'elaine' ),
				'parent'        => $panel_blog_lists,
				'default_value' => 'standard',
				'options'       => array(
					'standard'        => esc_html__( 'Standard', 'elaine' ),
					'load-more'       => esc_html__( 'Load More', 'elaine' ),
					'infinite-scroll' => esc_html__( 'Infinite Scroll', 'elaine' ),
					'no-pagination'   => esc_html__( 'No Pagination', 'elaine' )
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'number_of_chars',
				'default_value' => '40',
				'label'         => esc_html__( 'Number of Words in Excerpt', 'elaine' ),
				'description'   => esc_html__( 'Enter a number of words in excerpt (article summary). Default value is 40', 'elaine' ),
				'parent'        => $panel_blog_lists,
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_tags_area_blog',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Enable Blog Tags on Standard List', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show tags on standard blog list', 'elaine' ),
				'parent'        => $panel_blog_lists
			)
		);
		
		/**
		 * Blog Single
		 */
		$panel_blog_single = elaine_edge_add_admin_panel(
			array(
				'page'  => '_blog_page',
				'name'  => 'panel_blog_single',
				'title' => esc_html__( 'Blog Single', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'blog_single_grid_space',
				'type'        => 'select',
				'label'       => esc_html__( 'Grid Layout Space', 'elaine' ),
				'description' => esc_html__( 'Choose a space between content layout and sidebar layout for Blog Single pages. Default value is large', 'elaine' ),
				'options'     => elaine_edge_get_space_between_items_array( true ),
				'parent'      => $panel_blog_single
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'blog_single_sidebar_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout', 'elaine' ),
				'description'   => esc_html__( 'Choose a sidebar layout for Blog Single pages', 'elaine' ),
				'default_value' => '',
				'parent'        => $panel_blog_single,
                'options'       => elaine_edge_get_custom_sidebars_options()
			)
		);
		
		if ( count( $elaine_custom_sidebars ) > 0 ) {
			elaine_edge_add_admin_field(
				array(
					'name'        => 'blog_single_custom_sidebar_area',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Sidebar to Display', 'elaine' ),
					'description' => esc_html__( 'Choose a sidebar to display on Blog Single pages. Default sidebar is "Sidebar"', 'elaine' ),
					'parent'      => $panel_blog_single,
					'options'     => elaine_edge_get_custom_sidebars(),
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_blog',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single post pages', 'elaine' ),
				'parent'        => $panel_blog_single,
				'options'       => elaine_edge_get_yes_no_select_array(),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'blog_single_title_in_title_area',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show Post Title in Title Area', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show post title in title area on single post pages', 'elaine' ),
				'parent'        => $panel_blog_single,
				'dependency' => array(
					'hide' => array(
						'show_title_area_blog' => 'no'
					)
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'blog_single_related_posts',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Related Posts', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show related posts on single post pages', 'elaine' ),
				'parent'        => $panel_blog_single,
				'default_value' => 'yes'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'blog_single_comments',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Comments Form', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show comments form on single post pages', 'elaine' ),
				'parent'        => $panel_blog_single,
				'default_value' => 'yes'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_single_navigation',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Prev/Next Single Post Navigation Links', 'elaine' ),
				'description'   => esc_html__( 'Enable navigation links through the blog posts (left and right arrows will appear)', 'elaine' ),
				'parent'        => $panel_blog_single
			)
		);
		
		$blog_single_navigation_container = elaine_edge_add_admin_container(
			array(
				'name'            => 'edgtf_blog_single_navigation_container',
				'parent'          => $panel_blog_single,
				'dependency' => array(
					'show' => array(
						'blog_single_navigation' => 'yes'
					)
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_navigation_through_same_category',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Navigation Only in Current Category', 'elaine' ),
				'description'   => esc_html__( 'Limit your navigation only through current category', 'elaine' ),
				'parent'        => $blog_single_navigation_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_author_info',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Author Info Box', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will display author name and descriptions on single post pages. Author biographic info field in Users section must contain some data', 'elaine' ),
				'parent'        => $panel_blog_single
			)
		);
		
		$blog_single_author_info_container = elaine_edge_add_admin_container(
			array(
				'name'            => 'edgtf_blog_single_author_info_container',
				'parent'          => $panel_blog_single,
				'dependency' => array(
					'show' => array(
						'blog_author_info' => 'yes'
					)
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_author_info_email',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show Author Email', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show author email', 'elaine' ),
				'parent'        => $blog_single_author_info_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_single_author_social',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Author Social Icons', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show author social icons on single post pages', 'elaine' ),
				'parent'        => $blog_single_author_info_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		do_action( 'elaine_edge_action_blog_single_options_map', $panel_blog_single );
	}
	
	add_action( 'elaine_edge_action_options_map', 'elaine_edge_blog_options_map', elaine_edge_set_options_map_position( 'blog' ) );
}