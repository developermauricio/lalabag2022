<?php

if ( ! function_exists( 'elaine_edge_logo_options_map' ) ) {
	function elaine_edge_logo_options_map() {
		
		elaine_edge_add_admin_page(
			array(
				'slug'  => '_logo_page',
				'title' => esc_html__( 'Logo', 'elaine' ),
				'icon'  => 'fa fa-coffee'
			)
		);
		
		$panel_logo = elaine_edge_add_admin_panel(
			array(
				'page'  => '_logo_page',
				'name'  => 'panel_logo',
				'title' => esc_html__( 'Logo', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $panel_logo,
				'type'          => 'yesno',
				'name'          => 'hide_logo',
				'default_value' => 'no',
				'label'         => esc_html__( 'Hide Logo', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will hide logo image', 'elaine' )
			)
		);
		
		$hide_logo_container = elaine_edge_add_admin_container(
			array(
				'parent'          => $panel_logo,
				'name'            => 'hide_logo_container',
				'dependency' => array(
					'hide' => array(
						'hide_logo'  => 'yes'
					)
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'logo_image',
				'type'          => 'image',
				'default_value' => EDGE_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Default', 'elaine' ),
				'parent'        => $hide_logo_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'logo_image_dark',
				'type'          => 'image',
				'default_value' => EDGE_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Dark', 'elaine' ),
				'parent'        => $hide_logo_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'logo_image_light',
				'type'          => 'image',
				'default_value' => EDGE_ASSETS_ROOT . "/img/logo_white.png",
				'label'         => esc_html__( 'Logo Image - Light', 'elaine' ),
				'parent'        => $hide_logo_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'logo_image_sticky',
				'type'          => 'image',
				'default_value' => EDGE_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Sticky', 'elaine' ),
				'parent'        => $hide_logo_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'logo_image_mobile',
				'type'          => 'image',
				'default_value' => EDGE_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Mobile', 'elaine' ),
				'parent'        => $hide_logo_container
			)
		);
	}
	
	add_action( 'elaine_edge_action_options_map', 'elaine_edge_logo_options_map', elaine_edge_set_options_map_position( 'logo' ) );
}