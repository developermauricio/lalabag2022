<?php

if ( elaine_restaurant_theme_installed() ) {
	if ( ! function_exists( 'elaine_restaurant_options_map' ) ) {
		/**
		 * Adds admin page for OpenTable integration
		 */
		function elaine_restaurant_options_map() {
			elaine_edge_add_admin_page(
				array(
					'title' => esc_html__( 'Restaurant', 'elaine-restaurant' ),
					'slug'  => '_restaurant',
					'icon'  => 'fa fa-cutlery'
				)
			);
			
			//#Working Hours panel
			$panel_working_hours = elaine_edge_add_admin_panel(
				array(
					'page'  => '_restaurant',
					'name'  => 'panel_working_hours',
					'title' => esc_html__( 'Working Hours', 'elaine-restaurant' )
				)
			);
			
			$monday_group = elaine_edge_add_admin_group(
				array(
					'name'        => 'monday_group',
					'title'       => esc_html__( 'Monday', 'elaine-restaurant' ),
					'parent'      => $panel_working_hours,
					'description' => esc_html__( 'Working hours for Monday', 'elaine-restaurant' )
				)
			);
			
			$monday_row = elaine_edge_add_admin_row(
				array(
					'name'   => 'monday_row',
					'parent' => $monday_group
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_monday_from',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'From', 'elaine-restaurant' ),
					'parent' => $monday_row
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_monday_to',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'To', 'elaine-restaurant' ),
					'parent' => $monday_row
				)
			);
			
			$tuesday_group = elaine_edge_add_admin_group(
				array(
					'name'        => 'tuesday_group',
					'title'       => esc_html__( 'Tuesday', 'elaine-restaurant' ),
					'parent'      => $panel_working_hours,
					'description' => esc_html__( 'Working hours for Tuesday', 'elaine-restaurant' )
				)
			);
			
			$tuesday_row = elaine_edge_add_admin_row(
				array(
					'name'   => 'tuesday_row',
					'parent' => $tuesday_group
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_tuesday_from',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'From', 'elaine-restaurant' ),
					'parent' => $tuesday_row
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_tuesday_to',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'To', 'elaine-restaurant' ),
					'parent' => $tuesday_row
				)
			);
			
			$wednesday_group = elaine_edge_add_admin_group(
				array(
					'name'        => 'wednesday_group',
					'title'       => esc_html__( 'Wednesday', 'elaine-restaurant' ),
					'parent'      => $panel_working_hours,
					'description' => esc_html__( 'Working hours for Wednesday', 'elaine-restaurant' )
				)
			);
			
			$wednesday_row = elaine_edge_add_admin_row(
				array(
					'name'   => 'wednesday_row',
					'parent' => $wednesday_group
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_wednesday_from',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'From', 'elaine-restaurant' ),
					'parent' => $wednesday_row
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_wednesday_to',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'To', 'elaine-restaurant' ),
					'parent' => $wednesday_row
				)
			);
			
			$thursday_group = elaine_edge_add_admin_group(
				array(
					'name'        => 'thursday_group',
					'title'       => esc_html__( 'Thursday', 'elaine-restaurant' ),
					'parent'      => $panel_working_hours,
					'description' => esc_html__( 'Working hours for Thursday', 'elaine-restaurant' )
				)
			);
			
			$thursday_row = elaine_edge_add_admin_row(
				array(
					'name'   => 'thursday_row',
					'parent' => $thursday_group
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_thursday_from',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'From', 'elaine-restaurant' ),
					'parent' => $thursday_row
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_thursday_to',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'To', 'elaine-restaurant' ),
					'parent' => $thursday_row
				)
			);
			
			$friday_group = elaine_edge_add_admin_group(
				array(
					'name'        => 'friday_group',
					'title'       => esc_html__( 'Friday', 'elaine-restaurant' ),
					'parent'      => $panel_working_hours,
					'description' => esc_html__( 'Working hours for Friday', 'elaine-restaurant' )
				)
			);
			
			$friday_row = elaine_edge_add_admin_row(
				array(
					'name'   => 'friday_row',
					'parent' => $friday_group
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_friday_from',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'From', 'elaine-restaurant' ),
					'parent' => $friday_row
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_friday_to',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'To', 'elaine-restaurant' ),
					'parent' => $friday_row
				)
			);
			
			$saturday_group = elaine_edge_add_admin_group(
				array(
					'name'        => 'saturday_group',
					'title'       => esc_html__( 'Saturday', 'elaine-restaurant' ),
					'parent'      => $panel_working_hours,
					'description' => esc_html__( 'Working hours for Saturday', 'elaine-restaurant' )
				)
			);
			
			$saturday_row = elaine_edge_add_admin_row(
				array(
					'name'   => 'saturday_row',
					'parent' => $saturday_group
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_saturday_from',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'From', 'elaine-restaurant' ),
					'parent' => $saturday_row
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_saturday_to',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'To', 'elaine-restaurant' ),
					'parent' => $saturday_row
				)
			);
			
			$sunday_group = elaine_edge_add_admin_group(
				array(
					'name'        => 'sunday_group',
					'title'       => esc_html__( 'Sunday', 'elaine-restaurant' ),
					'parent'      => $panel_working_hours,
					'description' => esc_html__( 'Working hours for Sunday', 'elaine-restaurant' )
				)
			);
			
			$sunday_row = elaine_edge_add_admin_row(
				array(
					'name'   => 'sunday_row',
					'parent' => $sunday_group
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_sunday_from',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'From', 'elaine-restaurant' ),
					'parent' => $sunday_row
				)
			);
			
			elaine_edge_add_admin_field(
				array(
					'name'   => 'wh_sunday_to',
					'type'   => 'textsimple',
					'label'  => esc_html__( 'To', 'elaine-restaurant' ),
					'parent' => $sunday_row
				)
			);
		}
		
		add_action( 'elaine_edge_action_options_map', 'elaine_restaurant_options_map', 71 ); //one after elements
	}
}