<?php

if ( ! function_exists( 'elaine_edge_include_woocommerce_shortcodes' ) ) {
	function elaine_edge_include_woocommerce_shortcodes() {
		foreach ( glob( EDGE_FRAMEWORK_MODULES_ROOT_DIR . '/woocommerce/shortcodes/*/load.php' ) as $shortcode_load ) {
			include_once $shortcode_load;
		}
	}
	
	if ( elaine_edge_core_plugin_installed() ) {
		add_action( 'elaine_core_action_include_shortcodes_file', 'elaine_edge_include_woocommerce_shortcodes' );
	}
}
