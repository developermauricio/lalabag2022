<?php
namespace ElaineCore\CPT\Shortcodes\PricingItem;

use ElaineCore\Lib;

class PricingItem implements Lib\ShortcodeInterface {
    private $base;

    function __construct() {
        $this->base = 'edgtf_pricing_item';
        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
	    if ( function_exists( 'vc_map' ) ) {
		    vc_map( array(
			    'name'                      => esc_html__( 'Pricing Item', 'elaine-core' ),
			    'base'                      => $this->base,
			    'icon'                      => 'icon-wpb-pricing-item extended-custom-icon',
			    'category'                  => esc_html__( 'by ELAINE', 'elaine-core' ),
			    'allowed_container_element' => 'vc_row',
			    'params'                    => array(
				    array(
					    'type'       => 'textfield',
					    'param_name' => 'price_value',
					    'heading'    => esc_html__( 'Value', 'elaine-core' )
				    ),
				    array(
					    'type'       => 'colorpicker',
					    'param_name' => 'price_color',
					    'heading'    => esc_html__( 'Price Color', 'elaine-core' ),
					    'dependency' => array( 'element' => 'price_value', 'not_empty' => true )
				    ),
				    array(
					    'type'        => 'textfield',
					    'param_name'  => 'currency',
					    'heading'     => esc_html__( 'Currency', 'elaine-core' ),
					    'description' => esc_html__( 'Default mark is $', 'elaine-core' )
				    ),
				    array(
					    'type'       => 'colorpicker',
					    'param_name' => 'currency_color',
					    'heading'    => esc_html__( 'Currency Color', 'elaine-core' ),
					    'dependency' => array( 'element' => 'currency', 'not_empty' => true )
				    ),
				    array(
					    'type'        => 'textfield',
					    'param_name'  => 'title',
					    'heading'     => esc_html__( 'Title', 'elaine-core' ),
					    'save_always' => true
				    ),
				    array(
					    'type'       => 'textfield',
					    'param_name' => 'subtitle',
					    'heading'    => esc_html__( 'Subtitle', 'elaine-core' )
				    ),
				    array(
					    'type'       => 'textarea_html',
					    'param_name' => 'content',
					    'heading'    => esc_html__( 'Content', 'elaine-core' ),
					    'value'      => '<li>content content content</li><li>content content content</li><li>content content content</li>'
				    )
			    )
		    ) );
	    }
    }

    public function render($atts, $content = null) {
        $args = array(
            'price_value'         	=> '100',
            'price_color'           => '',
            'currency'      		=> '$',
            'currency_color'        => '',
            'title'         		=> '',
            'subtitle'              => ''
        );

        $params = shortcode_atts($args, $atts);
        extract($params);

        $html = '';

        $params['content']= preg_replace('#^<\/p>|<p>$#', '', $content); // delete p tag before and after content
        $params['price_styles'] = $this->getPriceStyles($params);
        $params['currency_styles'] = $this->getCurrencyStyles($params);

        $html .= elaine_core_get_shortcode_module_template_part('templates/pricing-item-template', 'pricing-item', '', $params);

        return $html;
    }

    private function getPriceStyles($params) {
        $itemStyle = array();

        if (!empty($params['price_color'])) {
            $itemStyle[] = 'color: '.$params['price_color'];
        }

        return implode(';', $itemStyle);
    }

    private function getCurrencyStyles($params) {
        $itemStyle = array();

        if (!empty($params['currency_color'])) {
            $itemStyle[] = 'color: '.$params['currency_color'];
        }

        return implode(';', $itemStyle);
    }
}