<?php

if ( ! function_exists( 'elaine_edge_map_woocommerce_meta' ) ) {
	function elaine_edge_map_woocommerce_meta() {
		
		$woocommerce_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'product' ),
				'title' => esc_html__( 'Product Meta', 'elaine' ),
				'name'  => 'woo_product_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_product_featured_image_size',
				'type'        => 'select',
				'label'       => esc_html__( 'Dimensions for Product List Shortcode', 'elaine' ),
				'description' => esc_html__( 'Choose image layout when it appears in Edge Product List - Masonry layout shortcode', 'elaine' ),
				'options'     => array(
					''                   => esc_html__( 'Default', 'elaine' ),
					'small'              => esc_html__( 'Small', 'elaine' ),
					'large-width'        => esc_html__( 'Large Width', 'elaine' ),
					'large-height'       => esc_html__( 'Large Height', 'elaine' ),
					'large-width-height' => esc_html__( 'Large Width Height', 'elaine' )
				),
				'parent'      => $woocommerce_meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_show_title_area_woo_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'elaine' ),
				'description'   => esc_html__( 'Disabling this option will turn off page title area', 'elaine' ),
				'options'       => elaine_edge_get_yes_no_select_array(),
				'parent'        => $woocommerce_meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_show_new_sign_woo_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show New Sign', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show new sign mark on product', 'elaine' ),
				'parent'        => $woocommerce_meta_box
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_woocommerce_meta', 99 );
}