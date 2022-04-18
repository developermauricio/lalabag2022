<?php

if ( ! function_exists( 'elaine_restaurant_style' ) && elaine_restaurant_theme_installed() ) {
	function elaine_restaurant_style() {
		$first_color = elaine_edge_options()->getOptionValue( 'first_color' );
		
		if ( ! empty( $first_color ) ) {
			echo elaine_edge_dynamic_css( '.edgtf-working-hours-holder .edgtf-wh-title .edgtf-wh-title-accent-word, #ui-datepicker-div .ui-datepicker-current-day:not(.ui-datepicker-today) a', array( 'color' => $first_color ) );
			
			echo elaine_edge_dynamic_css( '#ui-datepicker-div .ui-datepicker-today', array( 'background-color' => $first_color ) );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_restaurant_style' );
}