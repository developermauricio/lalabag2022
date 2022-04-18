<?php

if ( ! function_exists( 'elaine_edge_general_options_map' ) ) {
	/**
	 * General options page
	 */
	function elaine_edge_general_options_map() {
		
		elaine_edge_add_admin_page(
			array(
				'slug'  => '',
				'title' => esc_html__( 'General', 'elaine' ),
				'icon'  => 'fa fa-institution'
			)
		);
		
		$panel_design_style = elaine_edge_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_design_style',
				'title' => esc_html__( 'Design Style', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'google_fonts',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Google Font Family', 'elaine' ),
				'description'   => esc_html__( 'Choose a default Google font for your site', 'elaine' ),
				'parent'        => $panel_design_style
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'additional_google_fonts',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Additional Google Fonts', 'elaine' ),
				'parent'        => $panel_design_style
			)
		);
		
		$additional_google_fonts_container = elaine_edge_add_admin_container(
			array(
				'parent'          => $panel_design_style,
				'name'            => 'additional_google_fonts_container',
				'dependency' => array(
					'show' => array(
						'additional_google_fonts'  => 'yes'
					)
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'additional_google_font1',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'elaine' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'elaine' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'additional_google_font2',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'elaine' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'elaine' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'additional_google_font3',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'elaine' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'elaine' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'additional_google_font4',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'elaine' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'elaine' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'additional_google_font5',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'elaine' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'elaine' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'google_font_weight',
				'type'          => 'checkboxgroup',
				'default_value' => '',
				'label'         => esc_html__( 'Google Fonts Style & Weight', 'elaine' ),
				'description'   => esc_html__( 'Choose a default Google font weights for your site. Impact on page load time', 'elaine' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'100'  => esc_html__( '100 Thin', 'elaine' ),
					'100i' => esc_html__( '100 Thin Italic', 'elaine' ),
					'200'  => esc_html__( '200 Extra-Light', 'elaine' ),
					'200i' => esc_html__( '200 Extra-Light Italic', 'elaine' ),
					'300'  => esc_html__( '300 Light', 'elaine' ),
					'300i' => esc_html__( '300 Light Italic', 'elaine' ),
					'400'  => esc_html__( '400 Regular', 'elaine' ),
					'400i' => esc_html__( '400 Regular Italic', 'elaine' ),
					'500'  => esc_html__( '500 Medium', 'elaine' ),
					'500i' => esc_html__( '500 Medium Italic', 'elaine' ),
					'600'  => esc_html__( '600 Semi-Bold', 'elaine' ),
					'600i' => esc_html__( '600 Semi-Bold Italic', 'elaine' ),
					'700'  => esc_html__( '700 Bold', 'elaine' ),
					'700i' => esc_html__( '700 Bold Italic', 'elaine' ),
					'800'  => esc_html__( '800 Extra-Bold', 'elaine' ),
					'800i' => esc_html__( '800 Extra-Bold Italic', 'elaine' ),
					'900'  => esc_html__( '900 Ultra-Bold', 'elaine' ),
					'900i' => esc_html__( '900 Ultra-Bold Italic', 'elaine' )
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'google_font_subset',
				'type'          => 'checkboxgroup',
				'default_value' => '',
				'label'         => esc_html__( 'Google Fonts Subset', 'elaine' ),
				'description'   => esc_html__( 'Choose a default Google font subsets for your site', 'elaine' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'latin'        => esc_html__( 'Latin', 'elaine' ),
					'latin-ext'    => esc_html__( 'Latin Extended', 'elaine' ),
					'cyrillic'     => esc_html__( 'Cyrillic', 'elaine' ),
					'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'elaine' ),
					'greek'        => esc_html__( 'Greek', 'elaine' ),
					'greek-ext'    => esc_html__( 'Greek Extended', 'elaine' ),
					'vietnamese'   => esc_html__( 'Vietnamese', 'elaine' )
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'first_color',
				'type'        => 'color',
				'label'       => esc_html__( 'First Main Color', 'elaine' ),
				'description' => esc_html__( 'Choose the most dominant theme color. Default color is #ed5d29', 'elaine' ),
				'parent'      => $panel_design_style
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'page_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Page Background Color', 'elaine' ),
				'description' => esc_html__( 'Choose the background color for page content. Default color is #ffffff', 'elaine' ),
				'parent'      => $panel_design_style
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'page_background_image',
				'type'        => 'image',
				'label'       => esc_html__( 'Page Background Image', 'elaine' ),
				'description' => esc_html__( 'Choose the background image for page content', 'elaine' ),
				'parent'      => $panel_design_style
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'page_background_image_repeat',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Page Background Image Repeat', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will set the background image as a repeating pattern throughout the page, otherwise the image will appear as the cover background image', 'elaine' ),
				'parent'        => $panel_design_style
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'selection_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Text Selection Color', 'elaine' ),
				'description' => esc_html__( 'Choose the color users see when selecting text', 'elaine' ),
				'parent'      => $panel_design_style
			)
		);
		
		/***************** Passepartout Layout - begin **********************/
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'boxed',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Boxed Layout', 'elaine' ),
				'parent'        => $panel_design_style
			)
		);
		
			$boxed_container = elaine_edge_add_admin_container(
				array(
					'parent'          => $panel_design_style,
					'name'            => 'boxed_container',
					'dependency' => array(
						'show' => array(
							'boxed'  => 'yes'
						)
					)
				)
			);
		
				elaine_edge_add_admin_field(
					array(
						'name'        => 'page_background_color_in_box',
						'type'        => 'color',
						'label'       => esc_html__( 'Page Background Color', 'elaine' ),
						'description' => esc_html__( 'Choose the page background color outside box', 'elaine' ),
						'parent'      => $boxed_container
					)
				);
				
				elaine_edge_add_admin_field(
					array(
						'name'        => 'boxed_background_image',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'elaine' ),
						'description' => esc_html__( 'Choose an image to be displayed in background', 'elaine' ),
						'parent'      => $boxed_container
					)
				);
				
				elaine_edge_add_admin_field(
					array(
						'name'        => 'boxed_pattern_background_image',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Pattern', 'elaine' ),
						'description' => esc_html__( 'Choose an image to be used as background pattern', 'elaine' ),
						'parent'      => $boxed_container
					)
				);
				
				elaine_edge_add_admin_field(
					array(
						'name'          => 'boxed_background_image_attachment',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Background Image Attachment', 'elaine' ),
						'description'   => esc_html__( 'Choose background image attachment', 'elaine' ),
						'parent'        => $boxed_container,
						'options'       => array(
							''       => esc_html__( 'Default', 'elaine' ),
							'fixed'  => esc_html__( 'Fixed', 'elaine' ),
							'scroll' => esc_html__( 'Scroll', 'elaine' )
						)
					)
				);
		
		/***************** Boxed Layout - end **********************/
		
		/***************** Passepartout Layout - begin **********************/
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'paspartu',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Passepartout', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will display passepartout around site content', 'elaine' ),
				'parent'        => $panel_design_style
			)
		);
		
			$paspartu_container = elaine_edge_add_admin_container(
				array(
					'parent'          => $panel_design_style,
					'name'            => 'paspartu_container',
					'dependency' => array(
						'show' => array(
							'paspartu'  => 'yes'
						)
					)
				)
			);
		
				elaine_edge_add_admin_field(
					array(
						'name'        => 'paspartu_color',
						'type'        => 'color',
						'label'       => esc_html__( 'Passepartout Color', 'elaine' ),
						'description' => esc_html__( 'Choose passepartout color, default value is #ffffff', 'elaine' ),
						'parent'      => $paspartu_container
					)
				);
				
				elaine_edge_add_admin_field(
					array(
						'name'        => 'paspartu_width',
						'type'        => 'text',
						'label'       => esc_html__( 'Passepartout Size', 'elaine' ),
						'description' => esc_html__( 'Enter size amount for passepartout', 'elaine' ),
						'parent'      => $paspartu_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
		
				elaine_edge_add_admin_field(
					array(
						'name'        => 'paspartu_responsive_width',
						'type'        => 'text',
						'label'       => esc_html__( 'Responsive Passepartout Size', 'elaine' ),
						'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (tablets and mobiles view)', 'elaine' ),
						'parent'      => $paspartu_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
				
				elaine_edge_add_admin_field(
					array(
						'parent'        => $paspartu_container,
						'type'          => 'yesno',
						'default_value' => 'no',
						'name'          => 'disable_top_paspartu',
						'label'         => esc_html__( 'Disable Top Passepartout', 'elaine' )
					)
				);
		
				elaine_edge_add_admin_field(
					array(
						'parent'        => $paspartu_container,
						'type'          => 'yesno',
						'default_value' => 'no',
						'name'          => 'enable_fixed_paspartu',
						'label'         => esc_html__( 'Enable Fixed Passepartout', 'elaine' ),
						'description' => esc_html__( 'Enabling this option will set fixed passepartout for your screens', 'elaine' )
					)
				);
		
		/***************** Passepartout Layout - end **********************/
		
		/***************** Content Layout - begin **********************/
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'initial_content_width',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Initial Width of Content', 'elaine' ),
				'description'   => esc_html__( 'Choose the initial width of content which is in grid (Applies to pages set to "Default Template" and rows set to "In Grid")', 'elaine' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'edgtf-grid-1100' => esc_html__( '1100px - default', 'elaine' ),
					'edgtf-grid-1300' => esc_html__( '1300px', 'elaine' ),
					'edgtf-grid-1200' => esc_html__( '1200px', 'elaine' ),
					'edgtf-grid-1000' => esc_html__( '1000px', 'elaine' ),
					'edgtf-grid-800'  => esc_html__( '800px', 'elaine' )
				)
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'preload_pattern_image',
				'type'          => 'image',
				'label'         => esc_html__( 'Preload Pattern Image', 'elaine' ),
				'description'   => esc_html__( 'Choose preload pattern image to be displayed until images are loaded', 'elaine' ),
				'parent'        => $panel_design_style
			)
		);
		
		/***************** Content Layout - end **********************/
		
		$panel_settings = elaine_edge_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_settings',
				'title' => esc_html__( 'Settings', 'elaine' )
			)
		);
		
		/***************** Smooth Scroll Layout - begin **********************/
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'page_smooth_scroll',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Smooth Scroll', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth scrolling effect on every page (except on Mac and touch devices)', 'elaine' ),
				'parent'        => $panel_settings
			)
		);
		
		/***************** Smooth Scroll Layout - end **********************/
		
		/***************** Smooth Page Transitions Layout - begin **********************/
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'smooth_page_transitions',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Smooth Page Transitions', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth transition between pages when clicking on links', 'elaine' ),
				'parent'        => $panel_settings
			)
		);
		
			$page_transitions_container = elaine_edge_add_admin_container(
				array(
					'parent'          => $panel_settings,
					'name'            => 'page_transitions_container',
					'dependency' => array(
						'show' => array(
							'smooth_page_transitions'  => 'yes'
						)
					)
				)
			);
		
				elaine_edge_add_admin_field(
					array(
						'name'          => 'page_transition_preloader',
						'type'          => 'yesno',
						'default_value' => 'no',
						'label'         => esc_html__( 'Enable Preloading Animation', 'elaine' ),
						'description'   => esc_html__( 'Enabling this option will display an animated preloader while the page content is loading', 'elaine' ),
						'parent'        => $page_transitions_container
					)
				);
				
				$page_transition_preloader_container = elaine_edge_add_admin_container(
					array(
						'parent'          => $page_transitions_container,
						'name'            => 'page_transition_preloader_container',
						'dependency' => array(
							'show' => array(
								'page_transition_preloader'  => 'yes'
							)
						)
					)
				);
				
					elaine_edge_add_admin_field(
						array(
							'name'   => 'smooth_pt_bgnd_color',
							'type'   => 'color',
							'label'  => esc_html__( 'Page Loader Background Color', 'elaine' ),
							'parent' => $page_transition_preloader_container
						)
					);
					
					$group_pt_spinner_animation = elaine_edge_add_admin_group(
						array(
							'name'        => 'group_pt_spinner_animation',
							'title'       => esc_html__( 'Loader Style', 'elaine' ),
							'description' => esc_html__( 'Define styles for loader spinner animation', 'elaine' ),
							'parent'      => $page_transition_preloader_container
						)
					);
					
					$row_pt_spinner_animation = elaine_edge_add_admin_row(
						array(
							'name'   => 'row_pt_spinner_animation',
							'parent' => $group_pt_spinner_animation
						)
					);
					
					elaine_edge_add_admin_field(
						array(
							'type'          => 'selectsimple',
							'name'          => 'smooth_pt_spinner_type',
							'default_value' => '',
							'label'         => esc_html__( 'Spinner Type', 'elaine' ),
							'parent'        => $row_pt_spinner_animation,
							'options'       => array(
								'elaine_loader'        	=> esc_html__( 'Elaine Loader', 'elaine' ),
								'rotate_circles'        => esc_html__( 'Rotate Circles', 'elaine' ),
								'pulse'                 => esc_html__( 'Pulse', 'elaine' ),
								'double_pulse'          => esc_html__( 'Double Pulse', 'elaine' ),
								'cube'                  => esc_html__( 'Cube', 'elaine' ),
								'rotating_cubes'        => esc_html__( 'Rotating Cubes', 'elaine' ),
								'stripes'               => esc_html__( 'Stripes', 'elaine' ),
								'wave'                  => esc_html__( 'Wave', 'elaine' ),
								'two_rotating_circles'  => esc_html__( '2 Rotating Circles', 'elaine' ),
								'five_rotating_circles' => esc_html__( '5 Rotating Circles', 'elaine' ),
								'atom'                  => esc_html__( 'Atom', 'elaine' ),
								'clock'                 => esc_html__( 'Clock', 'elaine' ),
								'mitosis'               => esc_html__( 'Mitosis', 'elaine' ),
								'lines'                 => esc_html__( 'Lines', 'elaine' ),
								'fussion'               => esc_html__( 'Fussion', 'elaine' ),
								'wave_circles'          => esc_html__( 'Wave Circles', 'elaine' ),
								'pulse_circles'         => esc_html__( 'Pulse Circles', 'elaine' )
							)
						)
					);
					
					elaine_edge_add_admin_field(
						array(
							'type' => 'image',
							'name' => 'smooth_pt_image',
							'default_value' => '',
							'parent' => $row_pt_spinner_animation,
							'dependency' => array(
								'show' => array(
									'smooth_pt_spinner_type' => 'elaine_loader'
								)
							)
						)
					);

					elaine_edge_add_admin_field(
						array(
							'type' => 'image',
							'name' => 'smooth_pt_image_detail',
							'default_value' => '',
							'parent' => $row_pt_spinner_animation,
							'dependency' => array(
								'show' => array(
									'smooth_pt_spinner_type' => 'elaine_loader'
								)
							)
						)
					);

					elaine_edge_add_admin_field(
						array(
							'type'          => 'colorsimple',
							'name'          => 'smooth_pt_spinner_color',
							'default_value' => '',
							'label'         => esc_html__( 'Spinner Color', 'elaine' ),
							'parent'        => $row_pt_spinner_animation,
							'dependency' => array(
								'hide' => array(
									'smooth_pt_spinner_type' => 'elaine_loader'
								)
							)
						)
					);
					
					elaine_edge_add_admin_field(
						array(
							'name'          => 'page_transition_fadeout',
							'type'          => 'yesno',
							'default_value' => 'no',
							'label'         => esc_html__( 'Enable Fade Out Animation', 'elaine' ),
							'description'   => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'elaine' ),
							'parent'        => $page_transitions_container
						)
					);
		
		/***************** Smooth Page Transitions Layout - end **********************/
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'show_back_button',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show "Back To Top Button"', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will display a Back to Top button on every page', 'elaine' ),
				'parent'        => $panel_settings
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'responsiveness',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Responsiveness', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will make all pages responsive', 'elaine' ),
				'parent'        => $panel_settings
			)
		);
		
		$panel_custom_code = elaine_edge_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_custom_code',
				'title' => esc_html__( 'Custom Code', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'custom_js',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Custom JS', 'elaine' ),
				'description' => esc_html__( 'Enter your custom Javascript here', 'elaine' ),
				'parent'      => $panel_custom_code
			)
		);
		
		$panel_google_api = elaine_edge_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_google_api',
				'title' => esc_html__( 'Google API', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'        => 'google_maps_api_key',
				'type'        => 'text',
				'label'       => esc_html__( 'Google Maps Api Key', 'elaine' ),
				'description' => esc_html__( 'Insert your Google Maps API key here. For instructions on how to create a Google Maps API key, please refer to our to our documentation.', 'elaine' ),
				'parent'      => $panel_google_api
			)
		);
	}
	
	add_action( 'elaine_edge_action_options_map', 'elaine_edge_general_options_map', elaine_edge_set_options_map_position( 'general' ) );
}

if ( ! function_exists( 'elaine_edge_page_general_style' ) ) {
	/**
	 * Function that prints page general inline styles
	 */
	function elaine_edge_page_general_style( $style ) {
		$current_style = '';
		$page_id       = elaine_edge_get_page_id();
		$class_prefix  = elaine_edge_get_unique_page_class( $page_id );
		
		$boxed_background_style = array();
		
		$boxed_page_background_color = elaine_edge_get_meta_field_intersect( 'page_background_color_in_box', $page_id );
		if ( ! empty( $boxed_page_background_color ) ) {
			$boxed_background_style['background-color'] = $boxed_page_background_color;
		}
		
		$boxed_page_background_image = elaine_edge_get_meta_field_intersect( 'boxed_background_image', $page_id );
		if ( ! empty( $boxed_page_background_image ) ) {
			$boxed_background_style['background-image']    = 'url(' . esc_url( $boxed_page_background_image ) . ')';
			$boxed_background_style['background-position'] = 'center 0px';
			$boxed_background_style['background-repeat']   = 'no-repeat';
		}
		
		$boxed_page_background_pattern_image = elaine_edge_get_meta_field_intersect( 'boxed_pattern_background_image', $page_id );
		if ( ! empty( $boxed_page_background_pattern_image ) ) {
			$boxed_background_style['background-image']    = 'url(' . esc_url( $boxed_page_background_pattern_image ) . ')';
			$boxed_background_style['background-position'] = '0px 0px';
			$boxed_background_style['background-repeat']   = 'repeat';
		}
		
		$boxed_page_background_attachment = elaine_edge_get_meta_field_intersect( 'boxed_background_image_attachment', $page_id );
		if ( ! empty( $boxed_page_background_attachment ) ) {
			$boxed_background_style['background-attachment'] = $boxed_page_background_attachment;
		}
		
		$boxed_background_selector = $class_prefix . '.edgtf-boxed .edgtf-wrapper';
		
		if ( ! empty( $boxed_background_style ) ) {
			$current_style .= elaine_edge_dynamic_css( $boxed_background_selector, $boxed_background_style );
		}
		
		$paspartu_style     = array();
		$paspartu_res_style = array();
		$paspartu_res_start = '@media only screen and (max-width: 1024px) {';
		$paspartu_res_end   = '}';
		
		$paspartu_header_selector                = array(
			'.edgtf-paspartu-enabled .edgtf-page-header .edgtf-fixed-wrapper.fixed',
			'.edgtf-paspartu-enabled .edgtf-sticky-header',
			'.edgtf-paspartu-enabled .edgtf-mobile-header.mobile-header-appear .edgtf-mobile-header-inner'
		);
		$paspartu_header_appear_selector         = array(
			'.edgtf-paspartu-enabled.edgtf-fixed-paspartu-enabled .edgtf-page-header .edgtf-fixed-wrapper.fixed',
			'.edgtf-paspartu-enabled.edgtf-fixed-paspartu-enabled .edgtf-sticky-header.header-appear',
			'.edgtf-paspartu-enabled.edgtf-fixed-paspartu-enabled .edgtf-mobile-header.mobile-header-appear .edgtf-mobile-header-inner'
		);
		
		$paspartu_header_style                   = array();
		$paspartu_header_appear_style            = array();
		$paspartu_header_responsive_style        = array();
		$paspartu_header_appear_responsive_style = array();
		
		$paspartu_color = elaine_edge_get_meta_field_intersect( 'paspartu_color', $page_id );
		if ( ! empty( $paspartu_color ) ) {
			$paspartu_style['background-color'] = $paspartu_color;
		}
		
		$paspartu_width = elaine_edge_get_meta_field_intersect( 'paspartu_width', $page_id );
		if ( $paspartu_width !== '' ) {
			if ( elaine_edge_string_ends_with( $paspartu_width, '%' ) || elaine_edge_string_ends_with( $paspartu_width, 'px' ) ) {
				$paspartu_style['padding'] = $paspartu_width;
				
				$paspartu_clean_width      = elaine_edge_string_ends_with( $paspartu_width, '%' ) ? elaine_edge_filter_suffix( $paspartu_width, '%' ) : elaine_edge_filter_suffix( $paspartu_width, 'px' );
				$paspartu_clean_width_mark = elaine_edge_string_ends_with( $paspartu_width, '%' ) ? '%' : 'px';
				
				$paspartu_header_style['left']              = $paspartu_width;
				$paspartu_header_style['width']             = 'calc(100% - ' . ( 2 * $paspartu_clean_width ) . $paspartu_clean_width_mark . ')';
				$paspartu_header_appear_style['margin-top'] = $paspartu_width;
			} else {
				$paspartu_style['padding'] = $paspartu_width . 'px';
				
				$paspartu_header_style['left']              = $paspartu_width . 'px';
				$paspartu_header_style['width']             = 'calc(100% - ' . ( 2 * $paspartu_width ) . 'px)';
				$paspartu_header_appear_style['margin-top'] = $paspartu_width . 'px';
			}
		}
		
		$paspartu_selector = $class_prefix . '.edgtf-paspartu-enabled .edgtf-wrapper';
		
		if ( ! empty( $paspartu_style ) ) {
			$current_style .= elaine_edge_dynamic_css( $paspartu_selector, $paspartu_style );
		}
		
		if ( ! empty( $paspartu_header_style ) ) {
			$current_style .= elaine_edge_dynamic_css( $paspartu_header_selector, $paspartu_header_style );
			$current_style .= elaine_edge_dynamic_css( $paspartu_header_appear_selector, $paspartu_header_appear_style );
		}
		
		$paspartu_responsive_width = elaine_edge_get_meta_field_intersect( 'paspartu_responsive_width', $page_id );
		if ( $paspartu_responsive_width !== '' ) {
			if ( elaine_edge_string_ends_with( $paspartu_responsive_width, '%' ) || elaine_edge_string_ends_with( $paspartu_responsive_width, 'px' ) ) {
				$paspartu_res_style['padding'] = $paspartu_responsive_width;
				
				$paspartu_clean_width      = elaine_edge_string_ends_with( $paspartu_responsive_width, '%' ) ? elaine_edge_filter_suffix( $paspartu_responsive_width, '%' ) : elaine_edge_filter_suffix( $paspartu_responsive_width, 'px' );
				$paspartu_clean_width_mark = elaine_edge_string_ends_with( $paspartu_responsive_width, '%' ) ? '%' : 'px';
				
				$paspartu_header_responsive_style['left']              = $paspartu_responsive_width;
				$paspartu_header_responsive_style['width']             = 'calc(100% - ' . ( 2 * $paspartu_clean_width ) . $paspartu_clean_width_mark . ')';
				$paspartu_header_appear_responsive_style['margin-top'] = $paspartu_responsive_width;
			} else {
				$paspartu_res_style['padding'] = $paspartu_responsive_width . 'px';
				
				$paspartu_header_responsive_style['left']              = $paspartu_responsive_width . 'px';
				$paspartu_header_responsive_style['width']             = 'calc(100% - ' . ( 2 * $paspartu_responsive_width ) . 'px)';
				$paspartu_header_appear_responsive_style['margin-top'] = $paspartu_responsive_width . 'px';
			}
		}
		
		if ( ! empty( $paspartu_res_style ) ) {
			$current_style .= $paspartu_res_start . elaine_edge_dynamic_css( $paspartu_selector, $paspartu_res_style ) . $paspartu_res_end;
		}
		
		if ( ! empty( $paspartu_header_responsive_style ) ) {
			$current_style .= $paspartu_res_start . elaine_edge_dynamic_css( $paspartu_header_selector, $paspartu_header_responsive_style ) . $paspartu_res_end;
			$current_style .= $paspartu_res_start . elaine_edge_dynamic_css( $paspartu_header_appear_selector, $paspartu_header_appear_responsive_style ) . $paspartu_res_end;
		}
		
		$current_style = $current_style . $style;
		
		return $current_style;
	}
	
	add_filter( 'elaine_edge_filter_add_page_custom_style', 'elaine_edge_page_general_style' );
}