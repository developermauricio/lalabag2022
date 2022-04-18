<?php
namespace ElaineCore\CPT\Shortcodes\SingleImage;

use ElaineCore\Lib;

class SingleImage implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'edgtf_single_image';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Single Image', 'elaine-core' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by ELAINE', 'elaine-core' ),
					'icon'                      => 'icon-wpb-single-image extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'attach_image',
							'param_name'  => 'image',
							'heading'     => esc_html__( 'Image', 'elaine-core' ),
							'description' => esc_html__( 'Select image from media library', 'elaine-core' )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'image_size',
							'heading'     => esc_html__( 'Image Size', 'elaine-core' ),
							'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size', 'elaine-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'enable_image_shadow',
							'heading'     => esc_html__( 'Enable Image Shadow', 'elaine-core' ),
							'value'       => array_flip( elaine_edge_get_yes_no_select_array( false ) ),
							'save_always' => true
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'image_behavior',
							'heading'    => esc_html__( 'Image Behavior', 'elaine-core' ),
							'value'      => array(
								esc_html__( 'None', 'elaine-core' )             => '',
								esc_html__( 'Open Lightbox', 'elaine-core' )    => 'lightbox',
								esc_html__( 'Open Custom Link', 'elaine-core' ) => 'custom-link',
								esc_html__( 'Zoom', 'elaine-core' )             => 'zoom',
								esc_html__( 'Grayscale', 'elaine-core' )        => 'grayscale',
								esc_html__( 'Moving on Hover', 'elaine-core' )  => 'moving'
							)
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'custom_link',
							'heading'    => esc_html__( 'Custom Link', 'elaine-core' ),
							'dependency' => array( 'element' => 'image_behavior', 'value' => array( 'custom-link' ) )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'custom_link_target',
							'heading'    => esc_html__( 'Custom Link Target', 'elaine-core' ),
							'value'      => array_flip( elaine_edge_get_link_target_array() ),
							'dependency' => Array( 'element' => 'image_behavior', 'value' => array( 'custom-link' ) )
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
			'image'               		=> '',
			'image_size'          		=> 'full',
			'enable_image_shadow' 		=> 'no',
			'image_behavior'      		=> '',
			'custom_link'         		=> '',
			'custom_link_target'  		=> '_self',
			'item_outline'	  	  		=> '',
			'background_image'	  		=> '',
			'image_outline_position'	=> ''
		);

		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes']     		= $this->getHolderClasses( $params );
		$params['holder_styles']      		= $this->getHolderStyles( $params );
		$params['image']              		= $this->getImage( $params );
		$params['image_size']         		= $this->getImageSize( $params['image_size'] );
		$params['image_behavior']     		= ! empty( $params['image_behavior'] ) ? $params['image_behavior'] : $args['image_behavior'];
		$params['custom_link_target'] 		= ! empty( $params['custom_link_target'] ) ? $params['custom_link_target'] : $args['custom_link_target'];
		$params['background_image_style'] 	= $this->getBackgroundImageStyles( $params );
		
		$html = elaine_core_get_shortcode_module_template_part( 'templates/single-image', 'single-image', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = $params['enable_image_shadow'] === 'yes' ? 'edgtf-has-shadow' : '';
		$holderClasses[] = ! empty( $params['image_behavior'] ) ? 'edgtf-image-behavior-' . $params['image_behavior'] : '';
		$holderClasses[] = $params['item_outline'] === 'yes' ? 'edgtf-si-item-outline' : '';
		$holderClasses[] = ! empty( $params['background_image'] ) ? 'edgtf-si-background-image-holder' : '';
		$holderClasses[] = ! empty( $params['image_outline_position'] ) ? 'edgtf-si-position-right' : '';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getHolderStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['image'] ) && $params['image_behavior'] === 'moving' ) {
			$image_original = wp_get_attachment_image_src( $params['image'], 'full' );
			
			$styles[] = 'background-image: url(' . $image_original[0] . ')';
		}
		
		return implode( ';', $styles );
	}

	private function getBackgroundImageStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['background_image'] ) ) {
			$image_original = wp_get_attachment_image_src( $params['background_image'], 'full' );
			
			$styles[] = 'background-image: url(' . $image_original[0] . ')';
		}
		
		return implode( ';', $styles );
	}
	
	private function getImage( $params ) {
		$image = array();
		
		if ( ! empty( $params['image'] ) ) {
			$id = $params['image'];
			
			$image['image_id'] = $id;
			$image_original    = wp_get_attachment_image_src( $id, 'full' );
			$image['url']      = $image_original[0];
			$image['alt']      = get_post_meta( $id, '_wp_attachment_image_alt', true );
		}
		
		return $image;
	}
	
	private function getImageSize( $image_size ) {
		$image_size = trim( $image_size );
		//Find digits
		preg_match_all( '/\d+/', $image_size, $matches );
		if ( in_array( $image_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) ) ) {
			return $image_size;
		} elseif ( ! empty( $matches[0] ) ) {
			return array(
				$matches[0][0],
				$matches[0][1]
			);
		} else {
			return 'thumbnail';
		}
	}
}