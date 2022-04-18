<?php

if ( elaine_edge_visual_composer_installed() ) {
	if ( ! function_exists( 'elaine_edge_ttsingle_hours_vc_map' ) ) {
		function elaine_edge_ttsingle_hours_vc_map() {
			vc_map(
				array(
					'name'                      => esc_html__( 'edge Timetable Event Hours', 'elaine' ),
					'base'                      => 'tt_event_hours',
					'category'                  => esc_html__( 'by ELAINE', 'elaine' ),
					'icon'                      => 'icon-a-wpb-timetable-events-hours extended-custom-icon',
					'allowed_container_element' => 'vc_row'
				)
			);
		}
		
		add_action( 'vc_before_init', 'elaine_edge_ttsingle_hours_vc_map' );
	}
	
	if ( ! function_exists( 'elaine_edge_ttsingle_info_holder' ) ) {
		function elaine_edge_ttsingle_info_holder() {
			vc_map(
				array(
					"name"            => esc_html__( 'edge Timetable Event Info Holder', 'elaine' ),
					'base'            => 'tt_items_list',
					'category'        => esc_html__( 'by ELAINE', 'elaine' ),
					'as_parent'       => array( 'only' => 'tt_item' ),
					'icon'            => 'icon-wpb-a-timetable-event-info-holder extended-custom-icon',
					'content_element' => true,
					'js_view'         => 'VcColumnView'
				)
			);
		}
		
		add_action( 'vc_before_init', 'elaine_edge_ttsingle_info_holder', 10 );
	}
	
	if ( ! function_exists( 'elaine_edge_ttsingle_info_table_item' ) ) {
		function elaine_edge_ttsingle_info_table_item() {
			vc_map(
				array(
					'name'      => esc_html__( 'edge Timetable Event Info Table Item', 'elaine' ),
					'base'      => 'tt_item',
					'as_child'  => array( 'only' => 'tt_items_list' ),
					'as_parent' => array( 'except' => 'vc_row, vc_accordion' ),
					'icon'      => 'icon-wpb-a-timetable-event-info-table-item extended-custom-icon',
					'category'  => esc_html__( 'By ELAINE', 'elaine' ),
					'params'    => array(
						array(
							'type'       => 'textfield',
							'param_name' => 'content',
							'heading'    => esc_html__( 'Label', 'elaine' )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'value',
							'heading'    => esc_html__( 'Value', 'elaine' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'type',
							'heading'     => esc_html__( 'Type', 'elaine' ),
							'value'       => array(
								esc_html__( 'Table', 'elaine' ) => 'info'
							),
							'save_always' => true
						)
					)
				)
			);
		}
		
		add_action( 'vc_before_init', 'elaine_edge_ttsingle_info_table_item', 11 );
	}
	
	class WPBakeryShortCode_Tt_Items_List extends WPBakeryShortCodesContainer {}
}