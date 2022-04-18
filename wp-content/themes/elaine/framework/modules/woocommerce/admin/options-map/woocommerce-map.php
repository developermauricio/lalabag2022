<?php

if ( ! function_exists( 'elaine_edge_woocommerce_options_map' ) ) {
	
	/**
	 * Add Woocommerce options page
	 */
	function elaine_edge_woocommerce_options_map() {
		
		elaine_edge_add_admin_page(
			array(
				'slug'  => '_woocommerce_page',
				'title' => esc_html__( 'Woocommerce', 'elaine' ),
				'icon'  => 'fa fa-shopping-cart'
			)
		);
		
		/**
		 * Product List Settings
		 */
		$panel_product_list = elaine_edge_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_product_list',
				'title' => esc_html__( 'Product List', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'woo_list_grid_space',
				'type'        => 'select',
				'label'       => esc_html__( 'Grid Layout Space', 'elaine' ),
				'description' => esc_html__( 'Choose a space between content layout and sidebar layout for main shop page', 'elaine' ),
				'options'     => elaine_edge_get_space_between_items_array( true ),
				'parent'      => $panel_product_list
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'edgtf_woo_product_list_columns',
				'label'         => esc_html__( 'Product List Columns', 'elaine' ),
				'default_value' => 'edgtf-woocommerce-columns-4',
				'description'   => esc_html__( 'Choose number of columns for main shop page', 'elaine' ),
				'options'       => array(
					'edgtf-woocommerce-columns-3' => esc_html__( '3 Columns', 'elaine' ),
					'edgtf-woocommerce-columns-4' => esc_html__( '4 Columns', 'elaine' )
				),
				'parent'        => $panel_product_list,
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'edgtf_woo_product_list_columns_space',
				'label'         => esc_html__( 'Space Between Items', 'elaine' ),
				'description'   => esc_html__( 'Select space between items for product listing and related products on single product', 'elaine' ),
				'default_value' => 'normal',
				'options'       => elaine_edge_get_space_between_items_array(),
				'parent'        => $panel_product_list,
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'edgtf_woo_products_per_page',
				'label'         => esc_html__( 'Number of products per page', 'elaine' ),
				'description'   => esc_html__( 'Set number of products on shop page', 'elaine' ),
				'parent'        => $panel_product_list,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'edgtf_products_list_title_tag',
				'label'         => esc_html__( 'Products Title Tag', 'elaine' ),
				'default_value' => 'h5',
				'options'       => elaine_edge_get_title_tag(),
				'parent'        => $panel_product_list,
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'woo_enable_percent_sign_value',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Percent Sign', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show percent value mark instead of sale label on products', 'elaine' ),
				'parent'        => $panel_product_list
			)
		);
		
		/**
		 * Single Product Settings
		 */
		$panel_single_product = elaine_edge_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_single_product',
				'title' => esc_html__( 'Single Product', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_woo',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single post pages', 'elaine' ),
				'parent'        => $panel_single_product,
				'options'       => elaine_edge_get_yes_no_select_array(),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'edgtf_single_product_title_tag',
				'default_value' => 'h3',
				'label'         => esc_html__( 'Single Product Title Tag', 'elaine' ),
				'options'       => elaine_edge_get_title_tag(),
				'parent'        => $panel_single_product,
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_number_of_thumb_images',
				'default_value' => '4',
				'label'         => esc_html__( 'Number of Thumbnail Images per Row', 'elaine' ),
				'options'       => array(
					'4' => esc_html__( 'Four', 'elaine' ),
					'3' => esc_html__( 'Three', 'elaine' ),
					'2' => esc_html__( 'Two', 'elaine' )
				),
				'parent'        => $panel_single_product
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_set_thumb_images_position',
				'default_value' => 'below-image',
				'label'         => esc_html__( 'Set Thumbnail Images Position', 'elaine' ),
				'options'       => array(
					'below-image'  => esc_html__( 'Below Featured Image', 'elaine' ),
					'on-left-side' => esc_html__( 'On The Left Side Of Featured Image', 'elaine' )
				),
				'parent'        => $panel_single_product
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_enable_single_product_zoom_image',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Zoom Maginfier', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show magnifier image on featured image hover', 'elaine' ),
				'parent'        => $panel_single_product,
				'options'       => elaine_edge_get_yes_no_select_array( false ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_set_single_images_behavior',
				'default_value' => 'pretty-photo',
				'label'         => esc_html__( 'Set Images Behavior', 'elaine' ),
				'options'       => array(
					'pretty-photo' => esc_html__( 'Pretty Photo Lightbox', 'elaine' ),
					'photo-swipe'  => esc_html__( 'Photo Swipe Lightbox', 'elaine' )
				),
				'parent'        => $panel_single_product
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'edgtf_woo_related_products_columns',
				'label'         => esc_html__( 'Related Products Columns', 'elaine' ),
				'default_value' => 'edgtf-woocommerce-columns-4',
				'description'   => esc_html__( 'Choose number of columns for related products on single product page', 'elaine' ),
				'options'       => array(
					'edgtf-woocommerce-columns-3' => esc_html__( '3 Columns', 'elaine' ),
					'edgtf-woocommerce-columns-4' => esc_html__( '4 Columns', 'elaine' )
				),
				'parent'        => $panel_single_product,
			)
		);

		do_action('elaine_edge_woocommerce_additional_options_map');
	}
	
	add_action( 'elaine_edge_action_options_map', 'elaine_edge_woocommerce_options_map', elaine_edge_set_options_map_position( 'woocommerce' ) );
}