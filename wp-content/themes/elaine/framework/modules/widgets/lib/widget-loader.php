<?php

if ( ! function_exists( 'elaine_edge_register_widgets' ) ) {
	function elaine_edge_register_widgets() {
		$widgets = apply_filters( 'elaine_edge_filter_register_widgets', $widgets = array() );

		if(elaine_edge_core_plugin_installed()) {
			foreach ($widgets as $widget) {
				elaine_edge_create_wp_widget($widget);
			}
		}
	}

	add_action( 'widgets_init', 'elaine_edge_register_widgets' );
}