<?php

if ( ! function_exists( 'elaine_edge_reset_options_map' ) ) {
	/**
	 * Reset options panel
	 */
	function elaine_edge_reset_options_map() {
		
		elaine_edge_add_admin_page(
			array(
				'slug'  => '_reset_page',
				'title' => esc_html__( 'Reset', 'elaine' ),
				'icon'  => 'fa fa-retweet'
			)
		);
		
		$panel_reset = elaine_edge_add_admin_panel(
			array(
				'page'  => '_reset_page',
				'name'  => 'panel_reset',
				'title' => esc_html__( 'Reset', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'reset_to_defaults',
				'default_value' => 'no',
				'label'         => esc_html__( 'Reset to Defaults', 'elaine' ),
				'description'   => esc_html__( 'This option will reset all Select Options values to defaults', 'elaine' ),
				'parent'        => $panel_reset
			)
		);
	}
	
	add_action( 'elaine_edge_action_options_map', 'elaine_edge_reset_options_map', elaine_edge_set_options_map_position( 'reset' ) );
}