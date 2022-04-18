<?php

if ( ! function_exists( 'elaine_edge_portfolio_options_map' ) ) {
	function elaine_edge_portfolio_options_map() {
		
		elaine_edge_add_admin_page(
			array(
				'slug'  => '_portfolio',
				'title' => esc_html__( 'Portfolio', 'elaine-core' ),
				'icon'  => 'fa fa-camera-retro'
			)
		);
		
		$panel_archive = elaine_edge_add_admin_panel(
			array(
				'title' => esc_html__( 'Portfolio Archive', 'elaine-core' ),
				'name'  => 'panel_portfolio_archive',
				'page'  => '_portfolio'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'portfolio_archive_number_of_items',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Items', 'elaine-core' ),
				'description' => esc_html__( 'Set number of items for your portfolio list on archive pages. Default value is 12', 'elaine-core' ),
				'parent'      => $panel_archive,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_archive_number_of_columns',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'elaine-core' ),
				'default_value' => 'four',
				'description'   => esc_html__( 'Set number of columns for your portfolio list on archive pages. Default value is Four columns', 'elaine-core' ),
				'parent'        => $panel_archive,
				'options'       => elaine_edge_get_number_of_columns_array( false, array( 'one', 'six' ) )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_archive_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'elaine-core' ),
				'description'   => esc_html__( 'Set space size between portfolio items for your portfolio list on archive pages. Default value is normal', 'elaine-core' ),
				'default_value' => 'normal',
				'options'       => elaine_edge_get_space_between_items_array(),
				'parent'        => $panel_archive
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_archive_image_size',
				'type'          => 'select',
				'label'         => esc_html__( 'Image Proportions', 'elaine-core' ),
				'default_value' => 'landscape',
				'description'   => esc_html__( 'Set image proportions for your portfolio list on archive pages. Default value is landscape', 'elaine-core' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'full'      => esc_html__( 'Original', 'elaine-core' ),
					'landscape' => esc_html__( 'Landscape', 'elaine-core' ),
					'portrait'  => esc_html__( 'Portrait', 'elaine-core' ),
					'square'    => esc_html__( 'Square', 'elaine-core' )
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_archive_item_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Item Style', 'elaine-core' ),
				'default_value' => 'standard-shader',
				'description'   => esc_html__( 'Set item style for your portfolio list on archive pages. Default value is Standard - Shader', 'elaine-core' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'standard-shader' => esc_html__( 'Standard - Shader', 'elaine-core' ),
					'gallery-overlay' => esc_html__( 'Gallery - Overlay', 'elaine-core' )
				)
			)
		);
		
		$panel = elaine_edge_add_admin_panel(
			array(
				'title' => esc_html__( 'Portfolio Single', 'elaine-core' ),
				'name'  => 'panel_portfolio_single',
				'page'  => '_portfolio'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_template',
				'type'          => 'select',
				'label'         => esc_html__( 'Portfolio Type', 'elaine-core' ),
				'default_value' => 'small-images',
				'description'   => esc_html__( 'Choose a default type for Single Project pages', 'elaine-core' ),
				'parent'        => $panel,
				'options'       => array(
					'huge-images'       => esc_html__( 'Portfolio Full Width Images', 'elaine-core' ),
					'images'            => esc_html__( 'Portfolio Images', 'elaine-core' ),
					'small-images'      => esc_html__( 'Portfolio Small Images', 'elaine-core' ),
					'slider'            => esc_html__( 'Portfolio Slider', 'elaine-core' ),
					'small-slider'      => esc_html__( 'Portfolio Small Slider', 'elaine-core' ),
					'gallery'           => esc_html__( 'Portfolio Gallery', 'elaine-core' ),
					'small-gallery'     => esc_html__( 'Portfolio Small Gallery', 'elaine-core' ),
					'masonry'           => esc_html__( 'Portfolio Masonry', 'elaine-core' ),
					'small-masonry'     => esc_html__( 'Portfolio Small Masonry', 'elaine-core' ),
					'custom'            => esc_html__( 'Portfolio Custom', 'elaine-core' ),
					'full-width-custom' => esc_html__( 'Portfolio Full Width Custom', 'elaine-core' )
				)
			)
		);
		
		/***************** Gallery Layout *****************/
		
		$portfolio_gallery_container = elaine_edge_add_admin_container(
			array(
				'parent'          => $panel,
				'name'            => 'portfolio_gallery_container',
				'dependency' => array(
					'show' => array(
						'portfolio_single_template'  => array(
							'gallery',
							'small-gallery'
						)
					)
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_gallery_columns_number',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'elaine-core' ),
				'default_value' => 'three',
				'description'   => esc_html__( 'Set number of columns for portfolio gallery type', 'elaine-core' ),
				'parent'        => $portfolio_gallery_container,
				'options'       => elaine_edge_get_number_of_columns_array( false, array( 'one', 'five', 'six' ) )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_gallery_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'elaine-core' ),
				'description'   => esc_html__( 'Set space size between columns for portfolio gallery type', 'elaine-core' ),
				'default_value' => 'normal',
				'options'       => elaine_edge_get_space_between_items_array(),
				'parent'        => $portfolio_gallery_container
			)
		);
		
		/***************** Gallery Layout *****************/
		
		/***************** Masonry Layout *****************/
		
		$portfolio_masonry_container = elaine_edge_add_admin_container(
			array(
				'parent'          => $panel,
				'name'            => 'portfolio_masonry_container',
				'dependency' => array(
					'show' => array(
						'portfolio_single_template'  => array(
							'masonry',
							'small-masonry'
						)
					)
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_masonry_columns_number',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'elaine-core' ),
				'default_value' => 'three',
				'description'   => esc_html__( 'Set number of columns for portfolio masonry type', 'elaine-core' ),
				'parent'        => $portfolio_masonry_container,
				'options'       => elaine_edge_get_number_of_columns_array( false, array( 'one', 'five', 'six' ) )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_masonry_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'elaine-core' ),
				'description'   => esc_html__( 'Set space size between columns for portfolio masonry type', 'elaine-core' ),
				'default_value' => 'normal',
				'options'       => elaine_edge_get_space_between_items_array(),
				'parent'        => $portfolio_masonry_container
			)
		);
		
		/***************** Masonry Layout *****************/
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_portfolio_single',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single projects', 'elaine-core' ),
				'parent'        => $panel,
				'options'       => array(
					''    => esc_html__( 'Default', 'elaine-core' ),
					'yes' => esc_html__( 'Yes', 'elaine-core' ),
					'no'  => esc_html__( 'No', 'elaine-core' )
				),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_lightbox_images',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Lightbox for Images', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will turn on lightbox functionality for projects with images', 'elaine-core' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_lightbox_videos',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Lightbox for Videos', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will turn on lightbox functionality for YouTube/Vimeo projects', 'elaine-core' ),
				'parent'        => $panel,
				'default_value' => 'no'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_enable_categories',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Categories', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will enable category meta description on single projects', 'elaine-core' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_hide_date',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Date', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will enable date meta on single projects', 'elaine-core' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_sticky_sidebar',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Sticky Side Text', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will make side text sticky on Single Project pages. This option works only for Full Width Images, Small Images, Small Gallery and Small Masonry portfolio types', 'elaine-core' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_comments',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Comments', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will show comments on your page', 'elaine-core' ),
				'parent'        => $panel,
				'default_value' => 'no'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_hide_pagination',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Hide Pagination', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will turn off portfolio pagination functionality', 'elaine-core' ),
				'parent'        => $panel,
				'default_value' => 'no'
			)
		);
		
		$container_navigate_category = elaine_edge_add_admin_container(
			array(
				'name'            => 'navigate_same_category_container',
				'parent'          => $panel,
				'dependency' => array(
					'hide' => array(
						'portfolio_single_hide_pagination'  => array(
							'yes'
						)
					)
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'portfolio_single_nav_same_category',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Pagination Through Same Category', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will make portfolio pagination sort through current category', 'elaine-core' ),
				'parent'        => $container_navigate_category,
				'default_value' => 'no'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'portfolio_single_slug',
				'type'        => 'text',
				'label'       => esc_html__( 'Portfolio Single Slug', 'elaine-core' ),
				'description' => esc_html__( 'Enter if you wish to use a different Single Project slug (Note: After entering slug, navigate to Settings -> Permalinks and click "Save" in order for changes to take effect)', 'elaine-core' ),
				'parent'      => $panel,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_options_map', 'elaine_edge_portfolio_options_map', elaine_edge_set_options_map_position( 'portfolio' ) );
}