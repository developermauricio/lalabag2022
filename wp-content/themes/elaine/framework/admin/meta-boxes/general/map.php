<?php

if ( ! function_exists( 'elaine_edge_map_general_meta' ) ) {
	function elaine_edge_map_general_meta() {
		
		$general_meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => apply_filters( 'elaine_edge_filter_set_scope_for_meta_boxes', array( 'page', 'post' ), 'general_meta' ),
				'title' => esc_html__( 'General', 'elaine' ),
				'name'  => 'general_meta'
			)
		);
		
		/***************** Slider Layout - begin **********************/
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_page_slider_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Slider Shortcode', 'elaine' ),
				'description' => esc_html__( 'Paste your slider shortcode here', 'elaine' ),
				'parent'      => $general_meta_box
			)
		);
		
		/***************** Slider Layout - begin **********************/
		
		/***************** Content Layout - begin **********************/
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_page_content_behind_header_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Always put content behind header', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will put page content behind page header', 'elaine' ),
				'parent'        => $general_meta_box
			)
		);
		
		$edgtf_content_padding_group = elaine_edge_add_admin_group(
			array(
				'name'        => 'content_padding_group',
				'title'       => esc_html__( 'Content Styles', 'elaine' ),
				'description' => esc_html__( 'Define styles for Content area', 'elaine' ),
				'parent'      => $general_meta_box
			)
		);
		
			$edgtf_content_padding_row = elaine_edge_add_admin_row(
				array(
					'name'   => 'edgtf_content_padding_row',
					'parent' => $edgtf_content_padding_group
				)
			);
			
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_page_background_color_meta',
						'type'        => 'colorsimple',
						'label'       => esc_html__( 'Page Background Color', 'elaine' ),
						'parent'      => $edgtf_content_padding_row
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_page_background_image_meta',
						'type'          => 'imagesimple',
						'label'         => esc_html__( 'Page Background Image', 'elaine' ),
						'parent'        => $edgtf_content_padding_row
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_page_background_repeat_meta',
						'type'          => 'selectsimple',
						'default_value' => '',
						'label'         => esc_html__( 'Page Background Image Repeat', 'elaine' ),
						'options'       => elaine_edge_get_yes_no_select_array(),
						'parent'        => $edgtf_content_padding_row
					)
				);
		
			$edgtf_content_padding_row_1 = elaine_edge_add_admin_row(
				array(
					'name'   => 'edgtf_content_padding_row_1',
					'next'   => true,
					'parent' => $edgtf_content_padding_group
				)
			);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'   => 'edgtf_page_content_padding',
						'type'   => 'textsimple',
						'label'  => esc_html__( 'Content Padding (eg. 10px 5px 10px 5px)', 'elaine' ),
						'parent' => $edgtf_content_padding_row_1,
						'args'        => array(
							'col_width' => 4
						)
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'    => 'edgtf_page_content_padding_mobile',
						'type'    => 'textsimple',
						'label'   => esc_html__( 'Content Padding for mobile (eg. 10px 5px 10px 5px)', 'elaine' ),
						'parent'  => $edgtf_content_padding_row_1,
						'args'        => array(
							'col_width' => 4
						)
					)
				);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_initial_content_width_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Initial Width of Content', 'elaine' ),
				'description'   => esc_html__( 'Choose the initial width of content which is in grid (Applies to pages set to "Default Template" and rows set to "In Grid")', 'elaine' ),
				'parent'        => $general_meta_box,
				'options'       => array(
					''                => esc_html__( 'Default', 'elaine' ),
					'edgtf-grid-1300' => esc_html__( '1300px', 'elaine' ),
					'edgtf-grid-1200' => esc_html__( '1200px', 'elaine' ),
					'edgtf-grid-1100' => esc_html__( '1100px', 'elaine' ),
					'edgtf-grid-1000' => esc_html__( '1000px', 'elaine' ),
					'edgtf-grid-800'  => esc_html__( '800px', 'elaine' )
				)
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_page_grid_space_meta',
				'type'        => 'select',
				'default_value' => '',
				'label'       => esc_html__( 'Grid Layout Space', 'elaine' ),
				'description' => esc_html__( 'Choose a space between content layout and sidebar layout for your page', 'elaine' ),
				'options'     => elaine_edge_get_space_between_items_array( true ),
				'parent'      => $general_meta_box
			)
		);
		
		/***************** Content Layout - end **********************/
		
		/***************** Boxed Layout - begin **********************/
		
		elaine_edge_create_meta_box_field(
			array(
				'name'    => 'edgtf_boxed_meta',
				'type'    => 'select',
				'label'   => esc_html__( 'Boxed Layout', 'elaine' ),
				'parent'  => $general_meta_box,
				'options' => elaine_edge_get_yes_no_select_array()
			)
		);
		
			$boxed_container_meta = elaine_edge_add_admin_container(
				array(
					'parent'          => $general_meta_box,
					'name'            => 'boxed_container_meta',
					'dependency' => array(
						'hide' => array(
							'edgtf_boxed_meta' => array( '', 'no' )
						)
					)
				)
			);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_page_background_color_in_box_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Page Background Color', 'elaine' ),
						'description' => esc_html__( 'Choose the page background color outside box', 'elaine' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_boxed_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'elaine' ),
						'description' => esc_html__( 'Choose an image to be displayed in background', 'elaine' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_boxed_pattern_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Pattern', 'elaine' ),
						'description' => esc_html__( 'Choose an image to be used as background pattern', 'elaine' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'          => 'edgtf_boxed_background_image_attachment_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Background Image Attachment', 'elaine' ),
						'description'   => esc_html__( 'Choose background image attachment', 'elaine' ),
						'parent'        => $boxed_container_meta,
						'options'       => array(
							''       => esc_html__( 'Default', 'elaine' ),
							'fixed'  => esc_html__( 'Fixed', 'elaine' ),
							'scroll' => esc_html__( 'Scroll', 'elaine' )
						)
					)
				);
		
		/***************** Boxed Layout - end **********************/
		
		/***************** Passepartout Layout - begin **********************/
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_paspartu_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Passepartout', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will display passepartout around site content', 'elaine' ),
				'parent'        => $general_meta_box,
				'options'       => elaine_edge_get_yes_no_select_array(),
			)
		);
		
			$paspartu_container_meta = elaine_edge_add_admin_container(
				array(
					'parent'          => $general_meta_box,
					'name'            => 'edgtf_paspartu_container_meta',
					'dependency' => array(
						'hide' => array(
							'edgtf_paspartu_meta'  => array('','no')
						)
					)
				)
			);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_paspartu_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Passepartout Color', 'elaine' ),
						'description' => esc_html__( 'Choose passepartout color, default value is #ffffff', 'elaine' ),
						'parent'      => $paspartu_container_meta
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_paspartu_width_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Passepartout Size', 'elaine' ),
						'description' => esc_html__( 'Enter size amount for passepartout', 'elaine' ),
						'parent'      => $paspartu_container_meta,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_paspartu_responsive_width_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Responsive Passepartout Size', 'elaine' ),
						'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (tablets and mobiles view)', 'elaine' ),
						'parent'      => $paspartu_container_meta,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
				
				elaine_edge_create_meta_box_field(
					array(
						'parent'        => $paspartu_container_meta,
						'type'          => 'select',
						'default_value' => '',
						'name'          => 'edgtf_disable_top_paspartu_meta',
						'label'         => esc_html__( 'Disable Top Passepartout', 'elaine' ),
						'options'       => elaine_edge_get_yes_no_select_array(),
					)
				);
		
				elaine_edge_create_meta_box_field(
					array(
						'parent'        => $paspartu_container_meta,
						'type'          => 'select',
						'default_value' => '',
						'name'          => 'edgtf_enable_fixed_paspartu_meta',
						'label'         => esc_html__( 'Enable Fixed Passepartout', 'elaine' ),
						'description'   => esc_html__( 'Enabling this option will set fixed passepartout for your screens', 'elaine' ),
						'options'       => elaine_edge_get_yes_no_select_array(),
					)
				);
		
		/***************** Passepartout Layout - end **********************/
		
		/***************** Smooth Page Transitions Layout - begin **********************/
		
		elaine_edge_create_meta_box_field(
			array(
				'name'          => 'edgtf_smooth_page_transitions_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Smooth Page Transitions', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth transition between pages when clicking on links', 'elaine' ),
				'parent'        => $general_meta_box,
				'options'       => elaine_edge_get_yes_no_select_array()
			)
		);
		
			$page_transitions_container_meta = elaine_edge_add_admin_container(
				array(
					'parent'     => $general_meta_box,
					'name'       => 'page_transitions_container_meta',
					'dependency' => array(
						'hide' => array(
							'edgtf_smooth_page_transitions_meta' => array( '', 'no' )
						)
					)
				)
			);
		
				elaine_edge_create_meta_box_field(
					array(
						'name'        => 'edgtf_page_transition_preloader_meta',
						'type'        => 'select',
						'label'       => esc_html__( 'Enable Preloading Animation', 'elaine' ),
						'description' => esc_html__( 'Enabling this option will display an animated preloader while the page content is loading', 'elaine' ),
						'parent'      => $page_transitions_container_meta,
						'options'     => elaine_edge_get_yes_no_select_array()
					)
				);
		
				$page_transition_preloader_container_meta = elaine_edge_add_admin_container(
					array(
						'parent'     => $page_transitions_container_meta,
						'name'       => 'page_transition_preloader_container_meta',
						'dependency' => array(
							'hide' => array(
								'edgtf_page_transition_preloader_meta' => array( '', 'no' )
							)
						)
					)
				);
				
					elaine_edge_create_meta_box_field(
						array(
							'name'   => 'edgtf_smooth_pt_bgnd_color_meta',
							'type'   => 'color',
							'label'  => esc_html__( 'Page Loader Background Color', 'elaine' ),
							'parent' => $page_transition_preloader_container_meta
						)
					);
					
					$group_pt_spinner_animation_meta = elaine_edge_add_admin_group(
						array(
							'name'        => 'group_pt_spinner_animation_meta',
							'title'       => esc_html__( 'Loader Style', 'elaine' ),
							'description' => esc_html__( 'Define styles for loader spinner animation', 'elaine' ),
							'parent'      => $page_transition_preloader_container_meta
						)
					);
					
					$row_pt_spinner_animation_meta = elaine_edge_add_admin_row(
						array(
							'name'   => 'row_pt_spinner_animation_meta',
							'parent' => $group_pt_spinner_animation_meta
						)
					);
					
					elaine_edge_create_meta_box_field(
						array(
							'type'    => 'selectsimple',
							'name'    => 'edgtf_smooth_pt_spinner_type_meta',
							'label'   => esc_html__( 'Spinner Type', 'elaine' ),
							'parent'  => $row_pt_spinner_animation_meta,
							'options' => array(
								''                      => esc_html__( 'Default', 'elaine' ),
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
					
					elaine_edge_create_meta_box_field(
						array(
							'type' => 'image',
							'name' => 'edgtf_smooth_pt_image_meta',
							'parent' => $row_pt_spinner_animation_meta,
							'dependency' => array(
								'show' => array(
									'edgtf_smooth_pt_spinner_type_meta' => 'elaine_loader'
								)
							)
						)
					);

					elaine_edge_create_meta_box_field(
						array(
							'type' => 'image',
							'name' => 'edgtf_smooth_pt_image_meta_detail_meta',
							'parent' => $row_pt_spinner_animation_meta,
							'dependency' => array(
								'show' => array(
									'edgtf_smooth_pt_spinner_type_meta' => 'elaine_loader'
								)
							)
						)
					);

					elaine_edge_create_meta_box_field(
						array(
							'type'   => 'colorsimple',
							'name'   => 'edgtf_smooth_pt_spinner_color_meta',
							'label'  => esc_html__( 'Spinner Color', 'elaine' ),
							'parent' => $row_pt_spinner_animation_meta,
							'dependency' => array(
								'hide' => array(
									'edgtf_smooth_pt_spinner_type_meta' => 'elaine_loader'
								)
							)
						)
					);
					
					elaine_edge_create_meta_box_field(
						array(
							'name'        => 'edgtf_page_transition_fadeout_meta',
							'type'        => 'select',
							'label'       => esc_html__( 'Enable Fade Out Animation', 'elaine' ),
							'description' => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'elaine' ),
							'options'     => elaine_edge_get_yes_no_select_array(),
							'parent'      => $page_transitions_container_meta
						
						)
					);
		
		/***************** Smooth Page Transitions Layout - end **********************/
		
		/***************** Comments Layout - begin **********************/
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_page_comments_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Show Comments', 'elaine' ),
				'description' => esc_html__( 'Enabling this option will show comments on your page', 'elaine' ),
				'parent'      => $general_meta_box,
				'options'     => elaine_edge_get_yes_no_select_array()
			)
		);
		
		/***************** Comments Layout - end **********************/
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_edge_map_general_meta', 10 );
}

if ( ! function_exists( 'elaine_edge_container_background_style' ) ) {
	/**
	 * Function that return container style
	 */
	function elaine_edge_container_background_style( $style ) {
		$page_id      = elaine_edge_get_page_id();
		$class_prefix = elaine_edge_get_unique_page_class( $page_id, true );
		
		$container_selector = array(
			$class_prefix . ' .edgtf-content'
		);
		
		$container_class        = array();
		$page_background_color  = get_post_meta( $page_id, 'edgtf_page_background_color_meta', true );
		$page_background_image  = get_post_meta( $page_id, 'edgtf_page_background_image_meta', true );
		$page_background_repeat = get_post_meta( $page_id, 'edgtf_page_background_repeat_meta', true );
		
		if ( ! empty( $page_background_color ) ) {
			$container_class['background-color'] = $page_background_color;
		}
		
		if ( ! empty( $page_background_image ) ) {
			$container_class['background-image'] = 'url(' . esc_url( $page_background_image ) . ')';
			
			if ( $page_background_repeat === 'yes' ) {
				$container_class['background-repeat']   = 'repeat';
				$container_class['background-position'] = '0 0';
			} else {
				$container_class['background-repeat']   = 'no-repeat';
				$container_class['background-position'] = 'center 0';
				$container_class['background-size']     = 'cover';
			}
		}
		
		$current_style = elaine_edge_dynamic_css( $container_selector, $container_class );
		$current_style = $current_style . $style;
		
		return $current_style;
	}
	
	add_filter( 'elaine_edge_filter_add_page_custom_style', 'elaine_edge_container_background_style' );
}