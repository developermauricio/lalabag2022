<?php

if ( ! function_exists( 'elaine_restaurant_menu_meta_box_functions' ) ) {
	function elaine_restaurant_menu_meta_box_functions( $post_types ) {
		$post_types[] = 'restaurant-menu';
		
		return $post_types;
	}
	
	add_filter( 'elaine_edge_filter_meta_box_post_types_save', 'elaine_restaurant_menu_meta_box_functions' );
	add_filter( 'elaine_edge_filter_meta_box_post_types_remove', 'elaine_restaurant_menu_meta_box_functions' );
}

if ( ! function_exists( 'elaine_restaurant_register_restaurant_menu_cpt' ) ) {
	function elaine_restaurant_register_restaurant_menu_cpt( $cpt_class_name ) {
		$cpt_class = array(
			'ElaineRestaurant\CPT\RestaurantMenu\RestaurantMenuRegister'
		);
		
		$cpt_class_name = array_merge( $cpt_class_name, $cpt_class );
		
		return $cpt_class_name;
	}
	
	add_filter( 'elaine_restaurant_filter_register_custom_post_types', 'elaine_restaurant_register_restaurant_menu_cpt' );
}

// Load restaurant menu shortcodes
if ( ! function_exists( 'elaine_restaurant_include_restaurant_menu_shortcodes_file' ) ) {
	/**
	 * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
	 */
	function elaine_restaurant_include_restaurant_menu_shortcodes_file() {
		foreach ( glob( ELAINE_RESTAURANT_CPT_PATH . '/restaurant-menu/shortcodes/*/load.php' ) as $shortcode_load ) {
			include_once $shortcode_load;
		}
	}
	
	add_action( 'elaine_restaurant_include_shortcode_files', 'elaine_restaurant_include_restaurant_menu_shortcodes_file' );
}



