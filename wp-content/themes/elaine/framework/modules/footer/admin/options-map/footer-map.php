<?php

if ( ! function_exists( 'elaine_edge_footer_options_map' ) ) {
	function elaine_edge_footer_options_map() {

		elaine_edge_add_admin_page(
			array(
				'slug'  => '_footer_page',
				'title' => esc_html__( 'Footer', 'elaine' ),
				'icon'  => 'fa fa-sort-amount-asc'
			)
		);

		$footer_panel = elaine_edge_add_admin_panel(
			array(
				'title' => esc_html__( 'Footer', 'elaine' ),
				'name'  => 'footer',
				'page'  => '_footer_page'
			)
		);

		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'footer_in_grid',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Footer in Grid', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will place Footer content in grid', 'elaine' ),
				'parent'        => $footer_panel
			)
		);

        elaine_edge_add_admin_field(
            array(
                'type'          => 'yesno',
                'name'          => 'uncovering_footer',
                'default_value' => 'no',
                'label'         => esc_html__( 'Uncovering Footer', 'elaine' ),
                'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'elaine' ),
                'parent'        => $footer_panel,
            )
        );

		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_top',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Footer Top', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show Footer Top area', 'elaine' ),
				'parent'        => $footer_panel,
			)
		);
		
		$show_footer_top_container = elaine_edge_add_admin_container(
			array(
				'name'       => 'show_footer_top_container',
				'parent'     => $footer_panel,
				'dependency' => array(
					'show' => array(
						'show_footer_top' => 'yes'
					)
				)
			)
		);

		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_top_columns',
				'parent'        => $show_footer_top_container,
				'default_value' => '3 3 3 3',
				'label'         => esc_html__( 'Footer Top Columns', 'elaine' ),
				'description'   => esc_html__( 'Choose number of columns for Footer Top area', 'elaine' ),
				'options'       => array(
					'12' => '1',
					'6 6' => '2',
					'4 4 4' => '3',
                    '3 3 6' => '3 (25% + 25% + 50%)',
					'3 3 3 3' => '4'
				)
			)
		);

		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_top_columns_alignment',
				'default_value' => 'left',
				'label'         => esc_html__( 'Footer Top Columns Alignment', 'elaine' ),
				'description'   => esc_html__( 'Text Alignment in Footer Columns', 'elaine' ),
				'options'       => array(
					''       => esc_html__( 'Default', 'elaine' ),
					'left'   => esc_html__( 'Left', 'elaine' ),
					'center' => esc_html__( 'Center', 'elaine' ),
					'right'  => esc_html__( 'Right', 'elaine' )
				),
				'parent'        => $show_footer_top_container,
			)
		);

		elaine_edge_add_admin_field(
			array(
				'name'        => 'footer_top_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'elaine' ),
				'description' => esc_html__( 'Set background color for top footer area', 'elaine' ),
				'parent'      => $show_footer_top_container
			)
		);

		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_bottom',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Footer Bottom', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will show Footer Bottom area', 'elaine' ),
				'parent'        => $footer_panel,
			)
		);

		$show_footer_bottom_container = elaine_edge_add_admin_container(
			array(
				'name'            => 'show_footer_bottom_container',
				'parent'          => $footer_panel,
				'dependency' => array(
					'show' => array(
						'show_footer_bottom'  => 'yes'
					)
				)
			)
		);

		elaine_edge_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_bottom_columns',
				'default_value' => '6 6',
				'label'         => esc_html__( 'Footer Bottom Columns', 'elaine' ),
				'description'   => esc_html__( 'Choose number of columns for Footer Bottom area', 'elaine' ),
				'options'       => array(
					'12' => '1',
					'6 6' => '2',
					'4 4 4' => '3'
				),
				'parent'        => $show_footer_bottom_container,
			)
		);

		elaine_edge_add_admin_field(
			array(
				'name'        => 'footer_bottom_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'elaine' ),
				'description' => esc_html__( 'Set background color for bottom footer area', 'elaine' ),
				'parent'      => $show_footer_bottom_container
			)
		);
	}

	add_action( 'elaine_edge_action_options_map', 'elaine_edge_footer_options_map', elaine_edge_set_options_map_position( 'footer' ) );
}