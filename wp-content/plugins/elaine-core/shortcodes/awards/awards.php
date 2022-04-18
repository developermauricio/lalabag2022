<?php
namespace ElaineCore\CPT\Shortcodes\Awards;

use ElaineCore\Lib;

class Awards implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'edgtf_awards';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Awards', 'elaine-core' ),
					'base'                      => $this->base,
					'category'                  => esc_html__( 'by ELAINE', 'elaine-core' ),
					'icon'                      => 'icon-wpb-awards extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'custom_class',
							'heading'     => esc_html__( 'Custom CSS Class', 'elaine-core' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'elaine-core' )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'title',
							'heading'     => esc_html__( 'Title', 'elaine-core' ),
							'description' => esc_html__( 'Enter awards section title', 'elaine-core' )
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'title_styles',
							'heading'    => esc_html__( 'Title Color', 'elaine-core' )
						),
						
						array(
							'type' => 'param_group',
							'heading' => esc_html__( 'Awards Items', 'elaine-core' ),
							'param_name' => 'awards_items',
							'value' => '',
							'params' => array(
								
								array(
									'type'       => 'textfield',
									'param_name' => 'text',
									'heading'    => esc_html__( 'Text', 'elaine-core' )
								)
							)
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'items_styles',
							'heading'    => esc_html__( 'Items Color', 'elaine-core' )
						),
						
						array(
							'type'       => 'dropdown',
							'param_name' => 'appear_animation',
							'heading'    => esc_html__( 'Appear Animation', 'elaine-core' ),
							'value'       => array_flip( elaine_edge_get_yes_no_select_array( false, true ) )
						),
					)
				)
			);
		}
	}
	public function render( $atts, $content = null ) {
		$default_atts = array(
			'custom_class'    => '',
			'title'     => '',
			'title_styles' => '',
			'items_styles' => '',
			'awards_items' => '',
	        'appear_animation'		=> 'yes'
		);
		$params  = shortcode_atts( $default_atts, $atts );
		
		$params['holder_classes'] = $this->getHolderClasses($params);
		$params['separator_styles'] = $this->getSeparatorStyles($params);
		$params['title_styles'] = $this->getTitleStyles($params);
		$params['items_styles'] = $this->getItemsStyles($params);
		$params['awards_items'] = json_decode(urldecode($params['awards_items']), true);
		
		$output = elaine_core_get_shortcode_module_template_part( 'templates/awards-template', 'awards', '', $params );
		
		return $output;
	}
	
	private function getHolderClasses( $params ) {
		$holderClasses = array( 'edgtf-awards' );
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ($params['appear_animation'] == 'yes') ? 'edgtf-hidden-item edgtf-with-animation' : '';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getTitleStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['title_styles'] ) ) {
			$styles[] = 'color: ' . $params['title_styles'];
		}
		
		return $styles;
	}
	
	private function getItemsStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['items_styles'] ) ) {
			$styles[] = 'color: ' . $params['items_styles'];
		}
		
		return $styles;
	}
	
	private function getSeparatorStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['title_styles'] ) ) {
			$styles[] = 'background-color: ' . $params['title_styles'];
		}
		
		return $styles;
	}
}