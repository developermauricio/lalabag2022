<?php
namespace ElaineCore\CPT\Shortcodes\StackedImages;

use ElaineCore\Lib;

class StackedImages implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'edgtf_stacked_images';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'     => esc_html__( 'Stacked Images', 'elaine-core' ),
					'base'     => $this->base,
					'category' => esc_html__( 'by ELAINE', 'elaine-core' ),
					'icon'     => 'icon-wpb-stacked-images extended-custom-icon',
					'params'   => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'custom_class',
							'heading'     => esc_html__( 'Custom CSS Class', 'elaine-core' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'elaine-core' )
						),
						array(
							'type'       => 'attach_image',
							'param_name' => 'item_image',
							'heading'    => esc_html__( 'Image', 'elaine-core' )
						),
						array(
							'type'       => 'attach_image',
							'param_name' => 'item_stack_image',
							'heading'    => esc_html__( 'Stack Image', 'elaine-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'stack_image_position',
							'heading'     => esc_html__( 'Stack Image Position', 'elaine-core' ),
							'value'       => array(
								esc_html__( 'Left Offset', 'elaine-core' )  => 'left',
								esc_html__( 'Right Offset', 'elaine-core' ) => 'right'
							),
							'save_always' => true,
							'dependency'  => array( 'element' => 'item_stack_image', 'not_empty' => true )
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'         => '',
			'item_image'           => '',
			'item_stack_image'     => '',
			'stack_image_position' => 'left'
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes'] = $this->getHolderClasses( $params, $args );
		
		$html = elaine_core_get_shortcode_module_template_part( 'templates/stacked-images', 'stacked-images', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['stack_image_position'] ) ? 'edgtf-si-position-' . $params['stack_image_position'] : 'edgtf-si-position-' . $args['stack_image_position'];
		
		return implode( ' ', $holderClasses );
	}
}