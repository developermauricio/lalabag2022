<?php

namespace ElaineCore\CPT\Shortcodes\VideoButton;

use ElaineCore\Lib;

class VideoButton implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'edgtf_video_button';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Video Button', 'elaine-core' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by ELAINE', 'elaine-core' ),
					'icon'                      => 'icon-wpb-video-button extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'custom_class',
							'heading'     => esc_html__( 'Custom CSS Class', 'elaine-core' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'elaine-core' )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'video_link',
							'heading'    => esc_html__( 'Video Link', 'elaine-core' )
						),
						array(
							'type'        => 'attach_image',
							'param_name'  => 'video_image',
							'heading'     => esc_html__( 'Video Image', 'elaine-core' ),
							'description' => esc_html__( 'Select image from media library', 'elaine-core' )
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'play_button_color',
							'heading'    => esc_html__( 'Play Button Color', 'elaine-core' )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'play_button_size',
							'heading'    => esc_html__( 'Play Button Size (px)', 'elaine-core' )
						),
						array(
							'type'        => 'attach_image',
							'param_name'  => 'play_button_image',
							'heading'     => esc_html__( 'Play Button Custom Image', 'elaine-core' ),
							'description' => esc_html__( 'Select image from media library. If you use this field then play button color and button size options will not work', 'elaine-core' )
						),
						array(
							'type'        => 'attach_image',
							'param_name'  => 'play_button_hover_image',
							'heading'     => esc_html__( 'Play Button Custom Hover Image', 'elaine-core' ),
							'description' => esc_html__( 'Select image from media library. If you use this field then play button color and button size options will not work', 'elaine-core' )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'item_outline',
							'heading'    => esc_html__( 'Item Outline', 'elaine-core' ),
							'value'      => array_flip( elaine_edge_get_yes_no_select_array( false ) )
						),
						array(
							'type'        => 'attach_image',
							'param_name'  => 'background_image',
							'heading'     => esc_html__( 'Background Image', 'elaine-core' ),
							'value'       => array_flip( elaine_edge_get_link_target_array() )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'image_outline_position',
							'heading'    => esc_html__( 'Background Image/Outline Position', 'elaine-core' ),
							'value'      => array(
								esc_html__( 'Left', 'elaine-core' )     => '',
								esc_html__( 'Right', 'elaine-core' )    => 'right',
							),
							'dependency' => array('element' => 'item_outline', 'not_empty' => true),
						),
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'            => '',
			'video_link'              => '#',
			'video_image'             => '',
			'play_button_color'       => '',
			'play_button_size'        => '',
			'play_button_image'       => '',
			'play_button_hover_image' => '',
			'item_outline'	  	  	  => '',
			'background_image'	  	  => '',
			'image_outline_position'  => ''
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes']     		= $this->getHolderClasses( $params );
		$params['play_button_styles'] 		= $this->getPlayButtonStyles( $params );
		$params['background_image_style'] 	= $this->getBackgroundImageStyles( $params );
		
		$html = elaine_core_get_shortcode_module_template_part( 'templates/video-button', 'video-button', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['video_image'] ) ? 'edgtf-vb-has-img' : '';
		$holderClasses[] = $params['item_outline'] === 'yes' ? 'edgtf-vb-item-outline' : '';
		$holderClasses[] = ! empty( $params['background_image'] ) ? 'edgtf-vb-background-image-holder' : '';
		$holderClasses[] = ! empty( $params['image_outline_position'] ) ? 'edgtf-vb-position-right' : '';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getBackgroundImageStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['background_image'] ) ) {
			$image_original = wp_get_attachment_image_src( $params['background_image'], 'full' );
			
			$styles[] = 'background-image: url(' . $image_original[0] . ')';
		}
		
		return implode( ';', $styles );
	}

	private function getPlayButtonStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['play_button_color'] ) ) {
			$styles[] = 'color: ' . $params['play_button_color'];
		}
		
		if ( ! empty( $params['play_button_size'] ) ) {
			$styles[] = 'font-size: ' . elaine_edge_filter_px( $params['play_button_size'] ) . 'px';
		}
		
		return implode( ';', $styles );
	}
}