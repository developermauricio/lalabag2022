<?php

if ( elaine_restaurant_theme_installed() ) {
	if ( ! function_exists( 'elaine_restaurant_meta_box_map' ) ) {
		function elaine_restaurant_meta_box_map() {
			$restaurant_menu_meta_box = elaine_edge_create_meta_box(
				array(
					'scope' => array( 'restaurant-menu' ),
					'title' => esc_html__( 'Restaurant Menu Item Settings', 'elaine-restaurant' ),
					'name'  => 'cafe_menu_item_meta'
				)
			);

			elaine_edge_create_meta_box_field(
				array(
					'name'          => 'restaurant_menu_item_price',
					'type'          => 'text',
					'default_value' => '',
					'label'         => esc_html__('Restaurant Menu Item Price', 'elaine-restaurant'),
					'description'   => esc_html__('Enter price for this restaurant menu item', 'elaine-restaurant'),
					'parent'        => $restaurant_menu_meta_box,
					'args'          => array(
						'col_width' => '3'
					)
				)
			);

            elaine_edge_create_meta_box_field(
				array(
					'name'          => 'restaurant_menu_item_description',
					'type'          => 'text',
					'default_value' => '',
					'label'         => esc_html__('Restaurant Menu Item Description', 'elaine-restaurant'),
					'description'   => esc_html__('Enter description for this restaurant menu item', 'elaine-restaurant'),
					'parent'        => $restaurant_menu_meta_box,
				)
			);

            elaine_edge_create_meta_box_field(
				array(
					'name'          => 'restaurant_menu_item_label',
					'type'          => 'text',
					'default_value' => '',
					'label'         => esc_html__('Restaurant Menu Item Label', 'elaine-restaurant'),
					'description'   => esc_html__('Enter label for this restaurant menu item', 'elaine-restaurant'),
					'parent'        => $restaurant_menu_meta_box,
					'args'          => array(
						'col_width' => '3'
					)
				)
			);
		}
		
		add_action('elaine_edge_action_meta_boxes_map', 'elaine_restaurant_meta_box_map');
	}
}