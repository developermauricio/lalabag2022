<?php

if ( ! function_exists( 'elaine_edge_register_side_area_sidebar' ) ) {
	/**
	 * Register side area sidebar
	 */
	function elaine_edge_register_side_area_sidebar() {
		register_sidebar(
			array(
				'id'            => 'sidearea',
				'name'          => esc_html__( 'Side Area', 'elaine' ),
				'description'   => esc_html__( 'Side Area', 'elaine' ),
				'before_widget' => '<div id="%1$s" class="widget edgtf-sidearea %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="edgtf-widget-title-holder"><h5 class="edgtf-widget-title">',
				'after_title'   => '</h5></div>'
			)
		);
	}
	
	add_action( 'widgets_init', 'elaine_edge_register_side_area_sidebar' );
}

if ( ! function_exists( 'elaine_edge_side_menu_body_class' ) ) {
	/**
	 * Function that adds body classes for different side menu styles
	 *
	 * @param $classes array original array of body classes
	 *
	 * @return array modified array of classes
	 */
	function elaine_edge_side_menu_body_class( $classes ) {
		
		if ( is_active_widget( false, false, 'edgtf_side_area_opener' ) ) {
			
			if ( elaine_edge_options()->getOptionValue( 'side_area_type' ) ) {
				$classes[] = 'edgtf-' . elaine_edge_options()->getOptionValue( 'side_area_type' );
			}
		}
		
		return $classes;
	}
	
	add_filter( 'body_class', 'elaine_edge_side_menu_body_class' );
}

if ( ! function_exists( 'elaine_edge_get_side_area' ) ) {
	/**
	 * Loads side area HTML
	 */
	function elaine_edge_get_side_area() {
		
		if ( is_active_widget( false, false, 'edgtf_side_area_opener' ) ) {
			$parameters = array(
				'close_icon_classes' => elaine_edge_get_side_area_close_icon_class()
			);
			
			elaine_edge_get_module_template_part( 'templates/sidearea', 'sidearea', '', $parameters );
		}
	}
	
	add_action( 'elaine_edge_action_after_body_tag', 'elaine_edge_get_side_area', 10 );
}

if ( ! function_exists( 'elaine_edge_get_side_area_close_class' ) ) {
	/**
	 * Loads side area close icon class
	 */
	function elaine_edge_get_side_area_close_icon_class() {
		$classes = array(
			'edgtf-close-side-menu'
		);
		
		$classes[] = elaine_edge_get_icon_sources_class( 'side_area', 'edgtf-close-side-menu' );
		
		return $classes;
	}
}