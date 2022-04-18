<?php

if ( ! function_exists( 'elaine_core_enqueue_scripts_for_countdown_shortcodes' ) ) {
	/**
	 * Function that includes all necessary 3rd party scripts for this shortcode
	 */
	function elaine_core_enqueue_scripts_for_countdown_shortcodes() {
		wp_enqueue_script( 'countdown', ELAINE_CORE_SHORTCODES_URL_PATH . '/countdown/assets/js/plugins/jquery.countdown.min.js', array( 'jquery' ), false, true );
	}
	
	add_action( 'elaine_edge_action_enqueue_third_party_scripts', 'elaine_core_enqueue_scripts_for_countdown_shortcodes' );
}

if ( ! function_exists( 'elaine_core_add_countdown_shortcodes' ) ) {
	function elaine_core_add_countdown_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'ElaineCore\CPT\Shortcodes\Countdown\Countdown'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'elaine_core_filter_add_vc_shortcode', 'elaine_core_add_countdown_shortcodes' );
}

if ( ! function_exists( 'elaine_core_set_countdown_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for countdown shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function elaine_core_set_countdown_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-countdown';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'elaine_core_filter_add_vc_shortcodes_custom_icon_class', 'elaine_core_set_countdown_icon_class_name_for_vc_shortcodes' );
}