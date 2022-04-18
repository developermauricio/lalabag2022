<?php

if ( ! function_exists( 'elaine_edge_design_styles' ) ) {
	/**
	 * Generates general custom styles
	 */
	function elaine_edge_design_styles() {
		$font_family = elaine_edge_options()->getOptionValue( 'google_fonts' );
		if ( ! empty( $font_family ) && elaine_edge_is_font_option_valid( $font_family ) ) {
			$font_family_selector = array(
				'body'
			);
			echo elaine_edge_dynamic_css( $font_family_selector, array( 'font-family' => elaine_edge_get_font_option_val( $font_family ) ) );
		}
		
		$first_main_color = elaine_edge_options()->getOptionValue( 'first_color' );
		if ( ! empty( $first_main_color ) ) {
			$color_selector = $color_important_selector = $background_color_selector = $background_color_important_selector = $border_color_selector = $border_color_important_selector = array();
			
			// Include first main color selectors
			include_once 'parts/first-main-color.php';
			
			if ( elaine_edge_is_woocommerce_installed() ) {
				$woo_color_selector = $woo_color_important_selector = $woo_background_color_selector = $woo_background_color_important_selector = $woo_border_color_selector = $woo_border_color_important_selector = array();
				
				// Include first main color WooCommerce selectors
				include_once 'parts/woocommerce-first-main-color.php';
				
				if ( isset( $woo_color_selector ) && ! empty( $woo_color_selector ) ) {
					$color_selector = array_merge( $color_selector, $woo_color_selector );
				}
				
				if ( isset( $woo_color_important_selector ) && ! empty( $woo_color_important_selector ) ) {
					$color_important_selector = array_merge( $color_important_selector, $woo_color_important_selector );
				}
				
				if ( isset( $woo_background_color_selector ) && ! empty( $woo_background_color_selector ) ) {
					$background_color_selector = array_merge( $background_color_selector, $woo_background_color_selector );
				}
				
				if ( isset( $woo_background_color_important_selector ) && ! empty( $woo_background_color_important_selector ) ) {
					$background_color_important_selector = array_merge( $background_color_important_selector, $woo_background_color_important_selector );
				}
				
				if ( isset( $woo_border_color_selector ) && ! empty( $woo_border_color_selector ) ) {
					$border_color_selector = array_merge( $border_color_selector, $woo_border_color_selector );
				}
				
				if ( isset( $woo_border_color_important_selector ) && ! empty( $woo_border_color_important_selector ) ) {
					$border_color_important_selector = array_merge( $border_color_important_selector, $woo_border_color_important_selector );
				}
			}
			
			if ( isset( $color_selector ) && ! empty( $color_selector ) ) {
				echo elaine_edge_dynamic_css( $color_selector, array( 'color' => $first_main_color ) );
			}
			
			if ( isset( $color_important_selector ) && ! empty( $color_important_selector ) ) {
				echo elaine_edge_dynamic_css( $color_important_selector, array( 'color' => $first_main_color . '!important' ) );
			}
			
			if ( isset( $background_color_selector ) && ! empty( $background_color_selector ) ) {
				echo elaine_edge_dynamic_css( $background_color_selector, array( 'background-color' => $first_main_color ) );
			}
			
			if ( isset( $background_color_important_selector ) && ! empty( $background_color_important_selector ) ) {
				echo elaine_edge_dynamic_css( $background_color_important_selector, array( 'background-color' => $first_main_color . '!important' ) );
			}
			
			if ( isset( $border_color_selector ) && ! empty( $border_color_selector ) ) {
				echo elaine_edge_dynamic_css( $border_color_selector, array( 'border-color' => $first_main_color ) );
			}
			
			if ( isset( $border_color_important_selector ) && ! empty( $border_color_important_selector ) ) {
				echo elaine_edge_dynamic_css( $border_color_important_selector, array( 'border-color' => $first_main_color . '!important' ) );
			}
		}
		
		$page_background_color = elaine_edge_options()->getOptionValue( 'page_background_color' );
		if ( ! empty( $page_background_color ) ) {
			$background_color_selector = array(
				'body',
				'.edgtf-content'
			);
			echo elaine_edge_dynamic_css( $background_color_selector, array( 'background-color' => $page_background_color ) );
		}
		
		$page_background_image  = elaine_edge_options()->getOptionValue( 'page_background_image' );
		$page_background_repeat = elaine_edge_options()->getOptionValue( 'page_background_image_repeat' );
		
		if ( ! empty( $page_background_image ) ) {
			
			if ( $page_background_repeat === 'yes' ) {
				$background_image_style = array(
					'background-image'    => 'url(' . esc_url( $page_background_image ) . ')',
					'background-repeat'   => 'repeat',
					'background-position' => '0 0',
				);
			} else {
				$background_image_style = array(
					'background-image'    => 'url(' . esc_url( $page_background_image ) . ')',
					'background-repeat'   => 'no-repeat',
					'background-position' => 'center 0',
					'background-size'     => 'cover'
				);
			}
			
			echo elaine_edge_dynamic_css( '.edgtf-content', $background_image_style );
		}
		
		$selection_color = elaine_edge_options()->getOptionValue( 'selection_color' );
		if ( ! empty( $selection_color ) ) {
			echo elaine_edge_dynamic_css( '::selection', array( 'background' => $selection_color ) );
			echo elaine_edge_dynamic_css( '::-moz-selection', array( 'background' => $selection_color ) );
		}
		
		$preload_background_styles = array();
		
		if ( elaine_edge_options()->getOptionValue( 'preload_pattern_image' ) !== "" ) {
			$preload_background_styles['background-image'] = 'url(' . elaine_edge_options()->getOptionValue( 'preload_pattern_image' ) . ') !important';
		}
		
		echo elaine_edge_dynamic_css( '.edgtf-preload-background', $preload_background_styles );
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_design_styles' );
}

if ( ! function_exists( 'elaine_edge_content_styles' ) ) {
	function elaine_edge_content_styles() {
		$content_style = array();
		
		$padding = elaine_edge_options()->getOptionValue( 'content_padding' );
		if ( $padding !== '' ) {
			$content_style['padding'] = $padding;
		}
		
		$content_selector = array(
			'.edgtf-content .edgtf-content-inner > .edgtf-full-width > .edgtf-full-width-inner',
		);
		
		echo elaine_edge_dynamic_css( $content_selector, $content_style );
		
		$content_style_in_grid = array();
		
		$padding_in_grid = elaine_edge_options()->getOptionValue( 'content_padding_in_grid' );
		if ( $padding_in_grid !== '' ) {
			$content_style_in_grid['padding'] = $padding_in_grid;
		}
		
		$content_selector_in_grid = array(
			'.edgtf-content .edgtf-content-inner > .edgtf-container > .edgtf-container-inner',
		);
		
		echo elaine_edge_dynamic_css( $content_selector_in_grid, $content_style_in_grid );
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_content_styles' );
}

if ( ! function_exists( 'elaine_edge_h1_styles' ) ) {
	function elaine_edge_h1_styles() {
		$margin_top    = elaine_edge_options()->getOptionValue( 'h1_margin_top' );
		$margin_bottom = elaine_edge_options()->getOptionValue( 'h1_margin_bottom' );
		
		$item_styles = elaine_edge_get_typography_styles( 'h1' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = elaine_edge_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = elaine_edge_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h1'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo elaine_edge_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_h1_styles' );
}

if ( ! function_exists( 'elaine_edge_h2_styles' ) ) {
	function elaine_edge_h2_styles() {
		$margin_top    = elaine_edge_options()->getOptionValue( 'h2_margin_top' );
		$margin_bottom = elaine_edge_options()->getOptionValue( 'h2_margin_bottom' );
		
		$item_styles = elaine_edge_get_typography_styles( 'h2' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = elaine_edge_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = elaine_edge_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h2'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo elaine_edge_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_h2_styles' );
}

if ( ! function_exists( 'elaine_edge_h3_styles' ) ) {
	function elaine_edge_h3_styles() {
		$margin_top    = elaine_edge_options()->getOptionValue( 'h3_margin_top' );
		$margin_bottom = elaine_edge_options()->getOptionValue( 'h3_margin_bottom' );
		
		$item_styles = elaine_edge_get_typography_styles( 'h3' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = elaine_edge_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = elaine_edge_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h3'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo elaine_edge_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_h3_styles' );
}

if ( ! function_exists( 'elaine_edge_h4_styles' ) ) {
	function elaine_edge_h4_styles() {
		$margin_top    = elaine_edge_options()->getOptionValue( 'h4_margin_top' );
		$margin_bottom = elaine_edge_options()->getOptionValue( 'h4_margin_bottom' );
		
		$item_styles = elaine_edge_get_typography_styles( 'h4' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = elaine_edge_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = elaine_edge_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h4'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo elaine_edge_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_h4_styles' );
}

if ( ! function_exists( 'elaine_edge_h5_styles' ) ) {
	function elaine_edge_h5_styles() {
		$margin_top    = elaine_edge_options()->getOptionValue( 'h5_margin_top' );
		$margin_bottom = elaine_edge_options()->getOptionValue( 'h5_margin_bottom' );
		
		$item_styles = elaine_edge_get_typography_styles( 'h5' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = elaine_edge_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = elaine_edge_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h5'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo elaine_edge_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_h5_styles' );
}

if ( ! function_exists( 'elaine_edge_h6_styles' ) ) {
	function elaine_edge_h6_styles() {
		$margin_top    = elaine_edge_options()->getOptionValue( 'h6_margin_top' );
		$margin_bottom = elaine_edge_options()->getOptionValue( 'h6_margin_bottom' );
		
		$item_styles = elaine_edge_get_typography_styles( 'h6' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = elaine_edge_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = elaine_edge_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h6'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo elaine_edge_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_h6_styles' );
}

if ( ! function_exists( 'elaine_edge_text_styles' ) ) {
	function elaine_edge_text_styles() {
		$margin_top    = elaine_edge_options()->getOptionValue( 'text_margin_top' );
		$margin_bottom = elaine_edge_options()->getOptionValue( 'text_margin_bottom' );
		
		$item_styles = elaine_edge_get_typography_styles( 'text' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = elaine_edge_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = elaine_edge_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'p'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo elaine_edge_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_text_styles' );
}

if ( ! function_exists( 'elaine_edge_link_styles' ) ) {
	function elaine_edge_link_styles() {
		$link_styles      = array();
		$link_color       = elaine_edge_options()->getOptionValue( 'link_color' );
		$link_font_style  = elaine_edge_options()->getOptionValue( 'link_fontstyle' );
		$link_font_weight = elaine_edge_options()->getOptionValue( 'link_fontweight' );
		$link_decoration  = elaine_edge_options()->getOptionValue( 'link_fontdecoration' );
		
		if ( ! empty( $link_color ) ) {
			$link_styles['color'] = $link_color;
		}
		if ( ! empty( $link_font_style ) ) {
			$link_styles['font-style'] = $link_font_style;
		}
		if ( ! empty( $link_font_weight ) ) {
			$link_styles['font-weight'] = $link_font_weight;
		}
		if ( ! empty( $link_decoration ) ) {
			$link_styles['text-decoration'] = $link_decoration;
		}
		
		$link_selector = array(
			'a',
			'p a'
		);
		
		if ( ! empty( $link_styles ) ) {
			echo elaine_edge_dynamic_css( $link_selector, $link_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_link_styles' );
}

if ( ! function_exists( 'elaine_edge_link_hover_styles' ) ) {
	function elaine_edge_link_hover_styles() {
		$link_hover_styles     = array();
		$link_hover_color      = elaine_edge_options()->getOptionValue( 'link_hovercolor' );
		$link_hover_decoration = elaine_edge_options()->getOptionValue( 'link_hover_fontdecoration' );
		
		if ( ! empty( $link_hover_color ) ) {
			$link_hover_styles['color'] = $link_hover_color;
		}
		if ( ! empty( $link_hover_decoration ) ) {
			$link_hover_styles['text-decoration'] = $link_hover_decoration;
		}
		
		$link_hover_selector = array(
			'a:hover',
			'p a:hover'
		);
		
		if ( ! empty( $link_hover_styles ) ) {
			echo elaine_edge_dynamic_css( $link_hover_selector, $link_hover_styles );
		}
		
		$link_heading_hover_styles = array();
		
		if ( ! empty( $link_hover_color ) ) {
			$link_heading_hover_styles['color'] = $link_hover_color;
		}
		
		$link_heading_hover_selector = array(
			'h1 a:hover',
			'h2 a:hover',
			'h3 a:hover',
			'h4 a:hover',
			'h5 a:hover',
			'h6 a:hover'
		);
		
		if ( ! empty( $link_heading_hover_styles ) ) {
			echo elaine_edge_dynamic_css( $link_heading_hover_selector, $link_heading_hover_styles );
		}
	}
	
	add_action( 'elaine_edge_action_style_dynamic', 'elaine_edge_link_hover_styles' );
}

if ( ! function_exists( 'elaine_edge_smooth_page_transition_styles' ) ) {
	function elaine_edge_smooth_page_transition_styles( $style ) {
		$id            = elaine_edge_get_page_id();
		$loader_style  = array();
		$current_style = '';
		
		$background_color = elaine_edge_get_meta_field_intersect( 'smooth_pt_bgnd_color', $id );
		if ( ! empty( $background_color ) ) {
			$loader_style['background-color'] = $background_color;
		}
		
		$loader_selector = array(
			'.edgtf-smooth-transition-loader'
		);
		
		if ( ! empty( $loader_style ) ) {
			$current_style .= elaine_edge_dynamic_css( $loader_selector, $loader_style );
		}
		
		$spinner_style = array();
		$spinner_color = elaine_edge_get_meta_field_intersect( 'smooth_pt_spinner_color', $id );
		if ( ! empty( $spinner_color ) ) {
			$spinner_style['background-color'] = $spinner_color;
		}
		
		$spinner_selectors = array(
			'.edgtf-st-loader .edgtf-rotate-circles > div',
			'.edgtf-st-loader .pulse',
			'.edgtf-st-loader .double_pulse .double-bounce1',
			'.edgtf-st-loader .double_pulse .double-bounce2',
			'.edgtf-st-loader .cube',
			'.edgtf-st-loader .rotating_cubes .cube1',
			'.edgtf-st-loader .rotating_cubes .cube2',
			'.edgtf-st-loader .stripes > div',
			'.edgtf-st-loader .wave > div',
			'.edgtf-st-loader .two_rotating_circles .dot1',
			'.edgtf-st-loader .two_rotating_circles .dot2',
			'.edgtf-st-loader .five_rotating_circles .container1 > div',
			'.edgtf-st-loader .five_rotating_circles .container2 > div',
			'.edgtf-st-loader .five_rotating_circles .container3 > div',
			'.edgtf-st-loader .atom .ball-1:before',
			'.edgtf-st-loader .atom .ball-2:before',
			'.edgtf-st-loader .atom .ball-3:before',
			'.edgtf-st-loader .atom .ball-4:before',
			'.edgtf-st-loader .clock .ball:before',
			'.edgtf-st-loader .mitosis .ball',
			'.edgtf-st-loader .lines .line1',
			'.edgtf-st-loader .lines .line2',
			'.edgtf-st-loader .lines .line3',
			'.edgtf-st-loader .lines .line4',
			'.edgtf-st-loader .fussion .ball',
			'.edgtf-st-loader .fussion .ball-1',
			'.edgtf-st-loader .fussion .ball-2',
			'.edgtf-st-loader .fussion .ball-3',
			'.edgtf-st-loader .fussion .ball-4',
			'.edgtf-st-loader .wave_circles .ball',
			'.edgtf-st-loader .pulse_circles .ball'
		);
		
		if ( ! empty( $spinner_style ) ) {
			$current_style .= elaine_edge_dynamic_css( $spinner_selectors, $spinner_style );
		}
		
		$current_style = $current_style . $style;
		
		return $current_style;
	}
	
	add_filter( 'elaine_edge_filter_add_page_custom_style', 'elaine_edge_smooth_page_transition_styles' );
}