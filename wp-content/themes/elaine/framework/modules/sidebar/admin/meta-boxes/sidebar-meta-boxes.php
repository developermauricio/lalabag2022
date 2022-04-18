<?php

if ( ! function_exists( 'elaine_edge_map_sidebar_meta' ) ) {
	function elaine_edge_map_sidebar_meta() {
		$edgtf_sidebar_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => apply_filters( 'elaine_edge_filter_set_scope_for_meta_boxes', array( 'page' ), 'sidebar_meta' ),
				'title' => esc_html__( 'Sidebar', 'elaine' ),
				'name'  => 'sidebar_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_sidebar_layout_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Sidebar Layout', 'elaine' ),
				'description' => esc_html__( 'Choose the sidebar layout', 'elaine' ),
				'parent'      => $edgtf_sidebar_meta_box,
                'options'       => elaine_edge_get_custom_sidebars_options( true )
			)
		);
		
		$edgtf_custom_sidebars = elaine_edge_get_custom_sidebars();
		if ( count( $edgtf_custom_sidebars ) > 0 ) {
			elaine_edge_create_meta_box_field(
				array(
					'name'        => 'edgtf_custom_sidebar_area_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Choose Widget Area in Sidebar', 'elaine' ),
					'description' => esc_html__( 'Choose Custom Widget area to display in Sidebar"', 'elaine' ),
					'parent'      => $edgtf_sidebar_meta_box,
					'options'     => $edgtf_custom_sidebars,
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_sidebar_meta', 31 );
}