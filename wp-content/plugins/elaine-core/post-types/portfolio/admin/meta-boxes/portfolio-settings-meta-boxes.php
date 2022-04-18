<?php

if ( ! function_exists( 'elaine_core_map_portfolio_settings_meta' ) ) {
	function elaine_core_map_portfolio_settings_meta() {
		$meta_box = elaine_edge_create_meta_box( array(
			'scope' => 'portfolio-item',
			'title' => esc_html__( 'Portfolio Settings', 'elaine-core' ),
			'name'  => 'portfolio_settings_meta_box'
		) );
		
		elaine_edge_create_meta_box_field( array(
			'name'        => 'edgtf_portfolio_single_template_meta',
			'type'        => 'select',
			'label'       => esc_html__( 'Portfolio Type', 'elaine-core' ),
			'description' => esc_html__( 'Choose a default type for Single Project pages', 'elaine-core' ),
			'parent'      => $meta_box,
			'options'     => array(
				''                  => esc_html__( 'Default', 'elaine-core' ),
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
		) );
		
		/***************** Gallery Layout *****************/
		
		$gallery_type_meta_container = elaine_edge_add_admin_container(
			array(
				'parent'          => $meta_box,
				'name'            => 'edgtf_gallery_type_meta_container',
				'dependency' => array(
					'show' => array(
						'edgtf_portfolio_single_template_meta'  => array(
							'gallery',
							'small-gallery'
						)
					)
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_portfolio_single_gallery_columns_number_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'elaine-core' ),
				'default_value' => '',
				'description'   => esc_html__( 'Set number of columns for portfolio gallery type', 'elaine-core' ),
				'parent'        => $gallery_type_meta_container,
				'options'       => elaine_edge_get_number_of_columns_array( true, array( 'one', 'five', 'six' ) )
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_portfolio_single_gallery_space_between_items_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'elaine-core' ),
				'description'   => esc_html__( 'Set space size between columns for portfolio gallery type', 'elaine-core' ),
				'default_value' => '',
				'options'       => elaine_edge_get_space_between_items_array( true ),
				'parent'        => $gallery_type_meta_container
			)
		);
		
		/***************** Gallery Layout *****************/
		
		/***************** Masonry Layout *****************/
		
		$masonry_type_meta_container = elaine_edge_add_admin_container(
			array(
				'parent'          => $meta_box,
				'name'            => 'edgtf_masonry_type_meta_container',
				'dependency' => array(
					'show' => array(
						'edgtf_portfolio_single_template_meta'  => array(
							'masonry',
							'small-masonry'
						)
					)
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_portfolio_single_masonry_columns_number_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'elaine-core' ),
				'default_value' => '',
				'description'   => esc_html__( 'Set number of columns for portfolio masonry type', 'elaine-core' ),
				'parent'        => $masonry_type_meta_container,
				'options'       => elaine_edge_get_number_of_columns_array( true, array( 'one', 'five', 'six' ) )
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_portfolio_single_masonry_space_between_items_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'elaine-core' ),
				'description'   => esc_html__( 'Set space size between columns for portfolio masonry type', 'elaine-core' ),
				'default_value' => '',
				'options'       => elaine_edge_get_space_between_items_array( true ),
				'parent'        => $masonry_type_meta_container
			)
		);
		
		/***************** Masonry Layout *****************/
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_show_title_area_portfolio_single_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'elaine-core' ),
				'description'   => esc_html__( 'Enabling this option will show title area on your single portfolio page', 'elaine-core' ),
				'parent'        => $meta_box,
				'options'       => elaine_edge_get_yes_no_select_array()
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'portfolio_info_top_padding',
				'type'        => 'text',
				'label'       => esc_html__( 'Portfolio Info Top Padding', 'elaine-core' ),
				'description' => esc_html__( 'Set top padding for portfolio info elements holder. This option works only for Portfolio Images, Slider, Gallery and Masonry portfolio types', 'elaine-core' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'portfolio_external_link',
				'type'        => 'text',
				'label'       => esc_html__( 'Portfolio External Link', 'elaine-core' ),
				'description' => esc_html__( 'Enter URL to link from Portfolio List page', 'elaine-core' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_portfolio_featured_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Featured Image', 'elaine-core' ),
				'description' => esc_html__( 'Choose an image for Portfolio Lists shortcode where Hover Type option is Switch Featured Images', 'elaine-core' ),
				'parent'      => $meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_portfolio_masonry_fixed_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Dimensions for Masonry - Image Fixed Proportion', 'elaine-core' ),
				'description'   => esc_html__( 'Choose image layout when it appears in Masonry type portfolio lists where image proportion is fixed', 'elaine-core' ),
				'default_value' => '',
				'parent'        => $meta_box,
				'options'       => array(
					''                   => esc_html__( 'Default', 'elaine-core' ),
					'small'              => esc_html__( 'Small', 'elaine-core' ),
					'large-width'        => esc_html__( 'Large Width', 'elaine-core' ),
					'large-height'       => esc_html__( 'Large Height', 'elaine-core' ),
					'large-width-height' => esc_html__( 'Large Width/Height', 'elaine-core' )
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_portfolio_masonry_original_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Dimensions for Masonry - Image Original Proportion', 'elaine-core' ),
				'description'   => esc_html__( 'Choose image layout when it appears in Masonry type portfolio lists where image proportion is original', 'elaine-core' ),
				'default_value' => '',
				'parent'        => $meta_box,
				'options'       => array(
					''            => esc_html__( 'Default', 'elaine-core' ),
					'large-width' => esc_html__( 'Large Width', 'elaine-core' )
				)
			)
		);
		
		$all_pages = array();
		$pages     = get_pages();
		foreach ( $pages as $page ) {
			$all_pages[ $page->ID ] = $page->post_title;
		}
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'portfolio_single_back_to_link',
				'type'        => 'select',
				'label'       => esc_html__( '"Back To" Link', 'elaine-core' ),
				'description' => esc_html__( 'Choose "Back To" page to link from portfolio Single Project page', 'elaine-core' ),
				'parent'      => $meta_box,
				'options'     => $all_pages,
				'args'        => array(
					'select2' => true
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_core_map_portfolio_settings_meta', 41 );
}