<?php
namespace ElaineCore\CPT\Shortcodes\ItemShowcase;

use ElaineCore\Lib;

class ItemShowcaseItem implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'edgtf_item_showcase_item';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                    => esc_html__( 'Item Showcase List Item', 'elaine-core' ),
					'base'                    => $this->base,
					'as_child'                => array( 'only' => 'edgtf_item_showcase' ),
					'as_parent'               => array( 'except' => 'vc_row' ),
					'content_element'         => true,
					'category'                => esc_html__( 'by ELAINE', 'elaine-core' ),
					'icon'                    => 'icon-wpb-item-showcase-item extended-custom-icon',
					'show_settings_on_create' => true,
					'params'                  =>  array_merge(
						\ElaineEdgeClassIconCollections::get_instance()->getVCParamsArray(array(),'', true),
						array(
							array(
								'type' => 'attach_image',
								'heading' => esc_html__('Custom Icon', 'elaine-core'),
								'param_name' => 'custom_icon'
							),
							array(
								'type'       => 'attach_image',
								'param_name' => 'custom_hover_icon',
								'heading'    => esc_html__( 'Custom Hover Icon', 'elaine-core' ),
								'dependency' => array('element' => 'custom_icon', 'not_empty' => true)
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'item_position',
								'heading'     => esc_html__( 'Item Position', 'elaine-core' ),
								'value'       => array(
									esc_html__( 'Left', 'elaine-core' )  => 'left',
									esc_html__( 'Right', 'elaine-core' ) => 'right'
								),
								'save_always' => true,
								'admin_label' => true
							),
							array(
								'type'        => 'textfield',
								'param_name'  => 'item_title',
								'heading'     => esc_html__( 'Item Title', 'elaine-core' ),
								'admin_label' => true
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'item_link',
								'heading'    => esc_html__( 'Item Link', 'elaine-core' ),
								'dependency' => array( 'element' => 'item_title', 'not_empty' => true )
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'item_target',
								'heading'     => esc_html__( 'Item Target', 'elaine-core' ),
								'value'       => array_flip( elaine_edge_get_link_target_array() ),
								'dependency'  => array( 'element' => 'item_link', 'not_empty' => true ),
								'save_always' => true
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'item_title_tag',
								'heading'     => esc_html__( 'Item Title Tag', 'elaine-core' ),
								'value'       => array_flip( elaine_edge_get_title_tag( true ) ),
								'save_always' => true,
								'dependency'  => array( 'element' => 'item_title', 'not_empty' => true )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'item_title_color',
								'heading'    => esc_html__( 'Item Title Color', 'elaine-core' ),
								'dependency' => array( 'element' => 'item_title', 'not_empty' => true )
							),
							array(
								'type'       => 'textarea',
								'param_name' => 'item_text',
								'heading'    => esc_html__( 'Item Text', 'elaine-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'item_text_color',
								'heading'    => esc_html__( 'Item Text Color', 'elaine-core' ),
								'dependency' => array( 'element' => 'item_text', 'not_empty' => true )
							),
							array(
								'type' => 'colorpicker',
								'heading' => esc_html__('Icon Color', 'elaine-core'),
								'param_name' => 'icon_color',
								'description' => '',
								'group'      => esc_html__( 'Icon Options', 'elaine-core' )
							),
							array(
								'type' => 'textfield',
								'heading' => esc_html__('Icon Margin', 'elaine-core'),
								'param_name' => 'icon_margin',
								'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'elaine-core' ),
								'group'      => esc_html__( 'Icon Options', 'elaine-core' )
							)
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_icon'    	=> '',
			'custom_hover_icon'    => '',
			'item_position'    => 'left',
			'item_title'       => '',
			'item_link'        => '',
			'item_target'      => '_self',
			'item_title_tag'   => 'h5',
			'item_title_color' => '',
			'item_text'        => '',
			'item_text_color'  => '',
			'icon_color'		=> '',
			'icon_margin'		=> '',
		);
		$args = array_merge($args, elaine_edge_icon_collections()->getShortcodeParams());
		$params = shortcode_atts($args, $atts);
		extract($params);
		
		if(!empty($params['icon_pack'])) {
			$iconPackName = elaine_edge_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
			$params['icon'] = $params[$iconPackName];
			$params['icon_attributes']['style'] = $this->getIconStyle($params);
		}
		$params['showcase_item_class'] = $this->getShowcaseItemClasses( $params );
		$params['item_target']         = ! empty( $params['item_target'] ) ? $params['item_target'] : $args['item_target'];
		$params['item_title_tag']      = ! empty( $params['item_title_tag'] ) ? $params['item_title_tag'] : $args['item_title_tag'];
		$params['item_title_styles']   = $this->getTitleStyles( $params );
		$params['item_text_styles']    = $this->getTextStyles( $params );
		
		$html = elaine_core_get_shortcode_module_template_part( 'templates/item-showcase-item', 'item-showcase', '', $params );
		
		return $html;
	}
	
	private function getIconStyle($params)
	{
		
		$iconStylesArray = array();
		
		if (!empty($params['icon_margin'])) {
			$iconStylesArray[] = 'margin:' . $params['icon_margin'];
		}
		
		if (!empty($params['icon_color'])) {
			$iconStylesArray[] = 'color:' . $params['icon_color'];
		}
		
		return implode(';', $iconStylesArray);
	}
	
	private function getShowcaseItemClasses( $params ) {
		$itemClass = array();
		
		if ( ! empty( $params['item_position'] ) ) {
			$itemClass[] = 'edgtf-is-' . $params['item_position'];
		}
		
		$itemClass[] = ! empty( $params['custom_hover_icon'] ) ? 'edgtf-isi-has-hover-icon' : '';
		
		return implode( ' ', $itemClass );
	}
	
	private function getTitleStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['item_title_color'] ) ) {
			$styles[] = 'color: ' . $params['item_title_color'];
		}
		
		return implode( ';', $styles );
	}
	
	private function getTextStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['item_text_color'] ) ) {
			$styles[] = 'color: ' . $params['item_text_color'];
		}
		
		return implode( ';', $styles );
	}
}
