<?php

if(!function_exists('elaine_core_add_pricing_item_shortcodes')) {
    function elaine_core_add_pricing_item_shortcodes($shortcodes_class_name) {
        $shortcodes = array(
            'ElaineCore\CPT\Shortcodes\PricingItem\PricingItem'
        );

        $shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);

        return $shortcodes_class_name;
    }

    add_filter('elaine_core_filter_add_vc_shortcode', 'elaine_core_add_pricing_item_shortcodes');
}