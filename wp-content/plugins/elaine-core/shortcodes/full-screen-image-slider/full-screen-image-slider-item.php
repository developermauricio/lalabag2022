<?php
namespace ElaineCore\CPT\Shortcodes\FullScreenImageSlider;

use ElaineCore\Lib;

class FullScreenImageSliderItem implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'edgtf_full_screen_image_slider_item';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'      => esc_html__( 'Full Screen Image Slider Item', 'elaine-core' ),
					'base'      => $this->base,
					'category'  => esc_html__( 'by ELAINE', 'elaine-core' ),
					'as_child'  => array( 'only' => 'edgtf_full_screen_image_slider' ),
					'as_parent' => array( 'except' => 'vc_row' ),
					'icon'      => 'icon-wpb-full-screen-image-slider-item extended-custom-icon',
					'params'    => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'custom_class',
							'heading'     => esc_html__( 'Custom CSS Class', 'elaine-core' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'elaine-core' )
						),
						array(
							'type'       => 'attach_image',
							'param_name' => 'background_image',
							'heading'    => esc_html__( 'Background Image', 'elaine-core' )
						),
						array(
							'type'        => 'attach_image',
							'param_name'  => 'image_top',
							'heading'     => esc_html__( 'Content Image Top', 'elaine-core' ),
							'description' => esc_html__( 'Select image from media library', 'elaine-core' )
						),
						array(
							'type'        => 'attach_image',
							'param_name'  => 'image_left',
							'heading'     => esc_html__( 'Content Image Left', 'elaine-core' ),
							'description' => esc_html__( 'Select image from media library', 'elaine-core' )
						),
						array(
							'type'        => 'attach_image',
							'param_name'  => 'image_right',
							'heading'     => esc_html__( 'Content Image Right', 'elaine-core' ),
							'description' => esc_html__( 'Select image from media library', 'elaine-core' )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'title',
							'heading'    => esc_html__( 'Title', 'elaine-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'title_tag',
							'heading'     => esc_html__( 'Title Tag', 'elaine-core' ),
							'value'       => array_flip( elaine_edge_get_title_tag( true ) ),
							'save_always' => true,
							'dependency'  => array( 'element' => 'title', 'not_empty' => true )
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'title_color',
							'heading'    => esc_html__( 'Title Color', 'elaine-core' ),
							'dependency' => array( 'element' => 'title', 'not_empty' => true )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'subtitle',
							'heading'    => esc_html__( 'Subitle', 'elaine-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'subtitle_tag',
							'heading'     => esc_html__( 'Subitle Tag', 'elaine-core' ),
							'value'       => array_flip( elaine_edge_get_title_tag( true ) ),
							'save_always' => true,
							'dependency'  => array( 'element' => 'subtitle', 'not_empty' => true )
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'subtitle_color',
							'heading'    => esc_html__( 'Subitle Color', 'elaine-core' ),
							'dependency' => array( 'element' => 'subtitle', 'not_empty' => true )
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args = array(
			'custom_class'     => '',
			'background_image' => '',
			'image_top'        => '',
			'image_left'       => '',
			'image_right'      => '',
			'title'            => '',
			'title_tag'        => 'h1',
			'title_color'      => '',
			'subtitle'         => '',
			'subtitle_tag'     => 'h5',
			'subtitle_color'   => ''
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes'] = $this->getHolderClasses( $params );
		$params['image_styles']   = $this->getImageStyles( $params );
		$params['title_tag']      = ! empty( $params['title_tag'] ) ? $params['title_tag'] : $args['title_tag'];
		$params['title_styles']   = $this->getTitleStyles( $params );
		$params['subtitle_tag']      = ! empty( $params['subtitle_tag'] ) ? $params['subtitle_tag'] : $args['subtitle_tag'];
		$params['subtitle_styles']   = $this->getSubitleStyles( $params );
		
		$html = elaine_core_get_shortcode_module_template_part( 'templates/full-screen-image-slider-item', 'full-screen-image-slider', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getImageStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['background_image'] ) ) {
			$styles[] = 'background-image: url(' . wp_get_attachment_url( $params['background_image'] ) . ')';
		}
		
		return implode( ';', $styles );
	}
	
	private function getTitleStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['title_color'] ) ) {
			$styles[] = 'color: ' . $params['title_color'];
		}
		
		return implode( ';', $styles );
	}
	
	private function getSubitleStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['subtitle_color'] ) ) {
			$styles[] = 'color: ' . $params['subtitle_color'];
		}
		
		return implode( ';', $styles );
	}
}