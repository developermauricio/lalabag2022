<?php

if ( ! function_exists( 'elaine_restaurant_add_res_form_shortcodes' ) ) {
	function elaine_restaurant_add_res_form_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'ElaineRestaurant\Shortcodes\ReservationForm\ReservationForm'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'elaine_restaurant_add_vc_shortcode', 'elaine_restaurant_add_res_form_shortcodes' );
}

if ( ! function_exists( 'elaine_restaurant_set_res_form_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for property list shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function elaine_restaurant_set_res_form_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-reservation-form';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'elaine_restaurant_filter_add_vc_shortcodes_custom_icon_class', 'elaine_restaurant_set_res_form_icon_class_name_for_vc_shortcodes' );
}
