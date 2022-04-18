<?php

if ( ! function_exists( 'elaine_edge_sidebar_options_map' ) ) {
	function elaine_edge_sidebar_options_map() {
		
		elaine_edge_add_admin_page(
			array(
				'slug'  => '_sidebar_page',
				'title' => esc_html__( 'Sidebar Area', 'elaine' ),
				'icon'  => 'fa fa-indent'
			)
		);
		
		$sidebar_panel = elaine_edge_add_admin_panel(
			array(
				'title' => esc_html__( 'Sidebar Area', 'elaine' ),
				'name'  => 'sidebar',
				'page'  => '_sidebar_page'
			)
		);
		
		elaine_edge_add_admin_field( array(
			'name'          => 'sidebar_layout',
			'type'          => 'select',
			'label'         => esc_html__( 'Sidebar Layout', 'elaine' ),
			'description'   => esc_html__( 'Choose a sidebar layout for pages', 'elaine' ),
			'parent'        => $sidebar_panel,
			'default_value' => 'no-sidebar',
            'options'       => elaine_edge_get_custom_sidebars_options()
		) );
		
		$elaine_custom_sidebars = elaine_edge_get_custom_sidebars();
		if ( count( $elaine_custom_sidebars ) > 0 ) {
			elaine_edge_add_admin_field( array(
				'name'        => 'custom_sidebar_area',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Sidebar to Display', 'elaine' ),
				'description' => esc_html__( 'Choose a sidebar to display on pages. Default sidebar is "Sidebar"', 'elaine' ),
				'parent'      => $sidebar_panel,
				'options'     => $elaine_custom_sidebars,
				'args'        => array(
					'select2' => true
				)
			) );
		}
	}
	
	add_action( 'elaine_edge_action_options_map', 'elaine_edge_sidebar_options_map', elaine_edge_set_options_map_position( 'sidebar' ) );
}