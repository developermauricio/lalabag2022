<?php

if ( ! function_exists( 'elaine_edge_centered_title_type_options_meta_boxes' ) ) {
	function elaine_edge_centered_title_type_options_meta_boxes( $show_title_area_meta_container ) {
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_subtitle_side_padding_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Subtitle Side Padding', 'elaine' ),
				'description' => esc_html__( 'Set left/right padding for subtitle area', 'elaine' ),
				'parent'      => $show_title_area_meta_container,
				'args'        => array(
					'col_width' => 2,
					'suffix'    => 'px or %'
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_additional_title_area_meta_boxes', 'elaine_edge_centered_title_type_options_meta_boxes', 5 );
}