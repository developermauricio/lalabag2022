<?php

if ( ! function_exists( 'elaine_edge_error_404_options_map' ) ) {
	function elaine_edge_error_404_options_map() {
		
		elaine_edge_add_admin_page(
			array(
				'slug'  => '__404_error_page',
				'title' => esc_html__( '404 Error Page', 'elaine' ),
				'icon'  => 'fa fa-exclamation-triangle'
			)
		);
		
		$panel_404_header = elaine_edge_add_admin_panel(
			array(
				'page'  => '__404_error_page',
				'name'  => 'panel_404_header',
				'title' => esc_html__( 'Header', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'      => $panel_404_header,
				'type'        => 'color',
				'name'        => '404_menu_area_background_color_header',
				'label'       => esc_html__( 'Background Color', 'elaine' ),
				'description' => esc_html__( 'Choose a background color for header area', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $panel_404_header,
				'type'          => 'text',
				'name'          => '404_menu_area_background_transparency_header',
				'default_value' => '',
				'label'         => esc_html__( 'Background Transparency', 'elaine' ),
				'description'   => esc_html__( 'Choose a transparency for the header background color (0 = fully transparent, 1 = opaque)', 'elaine' ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'      => $panel_404_header,
				'type'        => 'color',
				'name'        => '404_menu_area_border_color_header',
				'label'       => esc_html__( 'Border Color', 'elaine' ),
				'description' => esc_html__( 'Choose a border bottom color for header area', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $panel_404_header,
				'type'          => 'select',
				'name'          => '404_header_style',
				'default_value' => '',
				'label'         => esc_html__( 'Header Skin', 'elaine' ),
				'description'   => esc_html__( 'Choose a header style to make header elements (logo, main menu, side menu button) in that predefined style', 'elaine' ),
				'options'       => array(
					''             => esc_html__( 'Default', 'elaine' ),
					'light-header' => esc_html__( 'Light', 'elaine' ),
					'dark-header'  => esc_html__( 'Dark', 'elaine' )
				)
			)
		);
		
		$panel_404_options = elaine_edge_add_admin_panel(
			array(
				'page'  => '__404_error_page',
				'name'  => 'panel_404_options',
				'title' => esc_html__( '404 Page Options', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent' => $panel_404_options,
				'type'   => 'color',
				'name'   => '404_page_background_color',
				'label'  => esc_html__( 'Background Color', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'      => $panel_404_options,
				'type'        => 'image',
				'name'        => '404_page_background_image',
				'label'       => esc_html__( 'Background Image', 'elaine' ),
				'description' => esc_html__( 'Choose a background image for 404 page', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'      => $panel_404_options,
				'type'        => 'image',
				'name'        => '404_page_background_pattern_image',
				'label'       => esc_html__( 'Pattern Background Image', 'elaine' ),
				'description' => esc_html__( 'Choose a pattern image for 404 page', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'      => $panel_404_options,
				'type'        => 'image',
				'name'        => '404_page_title_image',
				'label'       => esc_html__( 'Title Image', 'elaine' ),
				'description' => esc_html__( 'Choose a background image for displaying above 404 page Title', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $panel_404_options,
				'type'          => 'text',
				'name'          => '404_title',
				'default_value' => '',
				'label'         => esc_html__( 'Title', 'elaine' ),
				'description'   => esc_html__( 'Enter title for 404 page. Default label is "404".', 'elaine' )
			)
		);
		
		$first_level_group = elaine_edge_add_admin_group(
			array(
				'parent'      => $panel_404_options,
				'name'        => 'first_level_group',
				'title'       => esc_html__( 'Title Style', 'elaine' ),
				'description' => esc_html__( 'Define styles for 404 page title', 'elaine' )
			)
		);
		
		$first_level_row1 = elaine_edge_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row1'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent' => $first_level_row1,
				'type'   => 'colorsimple',
				'name'   => '404_title_color',
				'label'  => esc_html__( 'Text Color', 'elaine' ),
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'fontsimple',
				'name'          => '404_title_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'elaine' ),
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'textsimple',
				'name'          => '404_title_font_size',
				'default_value' => '',
				'label'         => esc_html__( 'Font Size', 'elaine' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'textsimple',
				'name'          => '404_title_line_height',
				'default_value' => '',
				'label'         => esc_html__( 'Line Height', 'elaine' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$first_level_row2 = elaine_edge_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row2',
				'next'   => true
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $first_level_row2,
				'type'          => 'selectblanksimple',
				'name'          => '404_title_font_style',
				'default_value' => '',
				'label'         => esc_html__( 'Font Style', 'elaine' ),
				'options'       => elaine_edge_get_font_style_array()
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $first_level_row2,
				'type'          => 'selectblanksimple',
				'name'          => '404_title_font_weight',
				'default_value' => '',
				'label'         => esc_html__( 'Font Weight', 'elaine' ),
				'options'       => elaine_edge_get_font_weight_array()
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $first_level_row2,
				'type'          => 'textsimple',
				'name'          => '404_title_letter_spacing',
				'default_value' => '',
				'label'         => esc_html__( 'Letter Spacing', 'elaine' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $first_level_row2,
				'type'          => 'selectblanksimple',
				'name'          => '404_title_text_transform',
				'default_value' => '',
				'label'         => esc_html__( 'Text Transform', 'elaine' ),
				'options'       => elaine_edge_get_text_transform_array()
			)
		);

        $first_level_group_responsive = elaine_edge_add_admin_group(
            array(
                'parent'      => $panel_404_options,
                'name'        => 'first_level_group_responsive',
                'title'       => esc_html__( 'Title Style Responsive', 'elaine' ),
                'description' => esc_html__( 'Define responsive styles for 404 page title (under 680px)', 'elaine' )
            )
        );

        $first_level_row3 = elaine_edge_add_admin_row(
            array(
                'parent' => $first_level_group_responsive,
                'name'   => 'first_level_row3'
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $first_level_row3,
                'type'          => 'textsimple',
                'name'          => '404_title_responsive_font_size',
                'default_value' => '',
                'label'         => esc_html__( 'Font Size', 'elaine' ),
                'args'          => array(
                    'suffix' => 'px'
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $first_level_row3,
                'type'          => 'textsimple',
                'name'          => '404_title_responsive_line_height',
                'default_value' => '',
                'label'         => esc_html__( 'Line Height', 'elaine' ),
                'args'          => array(
                    'suffix' => 'px'
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $first_level_row3,
                'type'          => 'textsimple',
                'name'          => '404_title_responsive_letter_spacing',
                'default_value' => '',
                'label'         => esc_html__( 'Letter Spacing', 'elaine' ),
                'args'          => array(
                    'suffix' => 'px'
                )
            )
        );
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $panel_404_options,
				'type'          => 'text',
				'name'          => '404_text',
				'default_value' => '',
				'label'         => esc_html__( 'Text', 'elaine' ),
				'description'   => esc_html__( 'Enter text for 404 page.', 'elaine' )
			)
		);
		
		$third_level_group = elaine_edge_add_admin_group(
			array(
				'parent'      => $panel_404_options,
				'name'        => '$third_level_group',
				'title'       => esc_html__( 'Text Style', 'elaine' ),
				'description' => esc_html__( 'Define styles for 404 page text', 'elaine' )
			)
		);
		
		$third_level_row1 = elaine_edge_add_admin_row(
			array(
				'parent' => $third_level_group,
				'name'   => '$third_level_row1'
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent' => $third_level_row1,
				'type'   => 'colorsimple',
				'name'   => '404_text_color',
				'label'  => esc_html__( 'Text Color', 'elaine' ),
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $third_level_row1,
				'type'          => 'fontsimple',
				'name'          => '404_text_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'elaine' ),
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $third_level_row1,
				'type'          => 'textsimple',
				'name'          => '404_text_font_size',
				'default_value' => '',
				'label'         => esc_html__( 'Font Size', 'elaine' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $third_level_row1,
				'type'          => 'textsimple',
				'name'          => '404_text_line_height',
				'default_value' => '',
				'label'         => esc_html__( 'Line Height', 'elaine' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$third_level_row2 = elaine_edge_add_admin_row(
			array(
				'parent' => $third_level_group,
				'name'   => '$third_level_row2',
				'next'   => true
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'selectblanksimple',
				'name'          => '404_text_font_style',
				'default_value' => '',
				'label'         => esc_html__( 'Font Style', 'elaine' ),
				'options'       => elaine_edge_get_font_style_array()
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'selectblanksimple',
				'name'          => '404_text_font_weight',
				'default_value' => '',
				'label'         => esc_html__( 'Font Weight', 'elaine' ),
				'options'       => elaine_edge_get_font_weight_array()
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'textsimple',
				'name'          => '404_text_letter_spacing',
				'default_value' => '',
				'label'         => esc_html__( 'Letter Spacing', 'elaine' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'selectblanksimple',
				'name'          => '404_text_text_transform',
				'default_value' => '',
				'label'         => esc_html__( 'Text Transform', 'elaine' ),
				'options'       => elaine_edge_get_text_transform_array()
			)
		);

        $third_level_group_responsive = elaine_edge_add_admin_group(
            array(
                'parent'      => $panel_404_options,
                'name'        => 'third_level_group_responsive',
                'title'       => esc_html__( 'Text Style Responsive', 'elaine' ),
                'description' => esc_html__( 'Define responsive styles for 404 page text (under 680px)', 'elaine' )
            )
        );

        $third_level_row3 = elaine_edge_add_admin_row(
            array(
                'parent' => $third_level_group_responsive,
                'name'   => 'third_level_row3'
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $third_level_row3,
                'type'          => 'textsimple',
                'name'          => '404_text_responsive_font_size',
                'default_value' => '',
                'label'         => esc_html__( 'Font Size', 'elaine' ),
                'args'          => array(
                    'suffix' => 'px'
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $third_level_row3,
                'type'          => 'textsimple',
                'name'          => '404_text_responsive_line_height',
                'default_value' => '',
                'label'         => esc_html__( 'Line Height', 'elaine' ),
                'args'          => array(
                    'suffix' => 'px'
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $third_level_row3,
                'type'          => 'textsimple',
                'name'          => '404_text_responsive_letter_spacing',
                'default_value' => '',
                'label'         => esc_html__( 'Letter Spacing', 'elaine' ),
                'args'          => array(
                    'suffix' => 'px'
                )
            )
        );
		
		elaine_edge_add_admin_field(
			array(
				'parent'      => $panel_404_options,
				'type'        => 'text',
				'name'        => '404_back_to_home',
				'label'       => esc_html__( 'Back to Home Button Label', 'elaine' ),
				'description' => esc_html__( 'Enter label for "Back to home" button', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'parent'        => $panel_404_options,
				'type'          => 'select',
				'name'          => '404_button_style',
				'default_value' => '',
				'label'         => esc_html__( 'Button Skin', 'elaine' ),
				'description'   => esc_html__( 'Choose a style to make Back to Home button in that predefined style', 'elaine' ),
				'options'       => array(
					''            => esc_html__( 'Default', 'elaine' ),
					'light-style' => esc_html__( 'Light', 'elaine' )
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_options_map', 'elaine_edge_error_404_options_map', elaine_edge_set_options_map_position( '404' ) );
}