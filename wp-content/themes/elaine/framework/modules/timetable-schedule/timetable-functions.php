<?php

if (!function_exists('elaine_edge_register_timetable_sidebars')) {
    /**
     * Function that registers theme's sidebars
     */
    function elaine_edge_register_timetable_sidebars() {

        register_sidebar(array(
            'name' => esc_html__('Sidebar Event', 'elaine'),
            'id' => 'sidebar-event',
            'description' => esc_html__('Default Sidebar for Timetable pages', 'elaine'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="edgtf-widget-title-holder"><h3 class="edgtf-widget-title">',
            'after_title' => '</h3></div>'
        ));
    }

    add_action('widgets_init', 'elaine_edge_register_timetable_sidebars', 1);
}

if ( ! function_exists( 'elaine_edge_get_tt_event_single_content' ) ) {
	/**
	 * Loads timetable single event page
	 */

	function elaine_edge_get_tt_event_single_content() {
		$subtitle = get_post_meta( get_the_ID(), 'timetable_subtitle', true );

		$params = array(
			'subtitle' => $subtitle
		);

        elaine_edge_get_module_template_part( 'templates/events-single', 'timetable-schedule', '', $params );
	}

}

if ( ! function_exists( 'elaine_edge_tt_events_single_default_sidebar' ) ) {
	/**
	 * Sets default sidebar for timetable single event event
	 *
	 * @param $sidebar
	 *
	 * @return string
	 */
	function elaine_edge_tt_events_single_default_sidebar( $sidebar ) {
		$page_id = elaine_edge_get_page_id();

		if ( get_post_type( $page_id ) === 'events' ) {
			$custom_sidebar_area = get_post_meta( $page_id, 'edgtf_custom_sidebar_area_meta', true );
			$sidebar             = ! empty( $custom_sidebar_area ) ? $custom_sidebar_area : 'sidebar-event';
		}

		return $sidebar;
	}

	add_filter( 'elaine_edge_filter_sidebar_name', 'elaine_edge_tt_events_single_default_sidebar' );
}

if(!function_exists('elaine_edge_events_scope_meta_box_functions')) {
	function elaine_edge_events_scope_meta_box_functions($post_types) {
		$post_types[] = 'events';
		//$post_types[] = 'tt-events';
		//$post_types[] = 'tribe_events';

		return $post_types;
	}

	add_filter('elaine_edge_filter_meta_box_post_types_save', 'elaine_edge_events_scope_meta_box_functions');
	add_filter('elaine_edge_filter_meta_box_post_types_remove', 'elaine_edge_events_scope_meta_box_functions');
	add_filter('elaine_edge_filter_set_scope_for_meta_boxes', 'elaine_edge_events_scope_meta_box_functions');
}

if ( ! function_exists( 'elaine_edge_set_timetable_event_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set timetable events class name for shortcodes to set our icon for Visual Composer shortcodes panel
	 */
	function elaine_edge_set_timetable_event_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-a-timetable-events-hours';
		$shortcodes_icon_class_array[] = '.icon-wpb-a-timetable-event-info-holder';
		$shortcodes_icon_class_array[] = '.icon-wpb-a-timetable-event-info-table-item';
		
		return $shortcodes_icon_class_array;
	}

	if ( elaine_edge_timetable_schedule_installed() ) {
		add_filter( 'elaine_core_filter_add_vc_shortcodes_custom_icon_class', 'elaine_edge_set_timetable_event_icon_class_name_for_vc_shortcodes' );
	}
}