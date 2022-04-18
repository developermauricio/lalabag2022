<?php
/**
 * Plugin generic functions file
 *
 * @package video player gallery
 * @since 1.0
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Function to load JS and CSS files
 * 
 * @package video player gallery
 * @since 1.1
 */ 
add_action( 'wp_enqueue_scripts','vpg_css_js' ); 
function vpg_css_js() {
    wp_enqueue_style( 'vpg_customjs_css', WP_VPG_URL.'vpg-assets/css/vpg-customjs.css', array(), WP_VPG_VERSION );
    wp_enqueue_style( 'vpg_custom_css',  WP_VPG_URL.'vpg-assets/css/vpg-custom.css', array(), WP_VPG_VERSION );
    wp_enqueue_style( 'vpg_font_awesome',  WP_VPG_URL.'vpg-assets/css/font-awesome.min.css', array(), WP_VPG_VERSION );
    // Registring and enqueing slick css
        if( !wp_style_is( 'wpoh-slick-css', 'registered' ) ) {
            wp_register_style( 'wpoh-slick-css', WP_VPG_URL.'vpg-assets/css/slick.css', array(), WP_VPG_VERSION );
            wp_enqueue_style( 'wpoh-slick-css');    
        }    
    // Registring and enqueing popup-style css
    if( !wp_style_is( 'wpoh-magnific-css', 'registered' ) ) {
            wp_enqueue_style( 'wpoh-magnific-css',  WP_VPG_URL. 'vpg-assets/css/popup.css', array(), WP_VPG_VERSION );
            wp_enqueue_style( 'wpoh-magnific-css' );
    }               
    wp_register_script( 'vpg_simple_js', WP_VPG_URL.'vpg-assets/js/simple-video.js', array('jquery'), WP_VPG_VERSION, true );
    wp_enqueue_script( 'vpg_simple_js' ); 
    if( !wp_script_is( 'wpoh-magnific-js', 'registered' ) ) {
            wp_register_script( 'wpoh-magnific-js', WP_VPG_URL.'vpg-assets/js/magnific-popup.min.js', array('jquery'), WP_VPG_VERSION, true );           
        }
    if( !wp_script_is( 'wpoh-slick-js', 'registered' ) ) {
            wp_register_script( 'wpoh-slick-js', WP_VPG_URL.'vpg-assets/js/slick.min.js', array('jquery'), WP_VPG_VERSION, true );           
        }   
    wp_register_script( 'vpg-custom-js', WP_VPG_URL.'vpg-assets/js/vpg-custom.js', array('jquery'), WP_VPG_VERSION, true );
    wp_localize_script( 'vpg-custom-js', 'Vpg', array());   
}
/**
 * Function to get static number
 * 
 * @package video player gallery
 * @since 1.0
 */ 
 function vpg_get_static() {
    static $static = 0;
    $static++;
    return $static;
}
/**
     * Function to add style at admin side
     * 
     * @package Video player gallery
     * @since 1.0.0
*/
   add_action( 'admin_enqueue_scripts', 'wp_vpg_admin_style');
   function wp_vpg_admin_style( $hook ) {
            // Registring and enqueing admin css
            wp_register_style( 'vpg-admin-style', WP_VPG_URL.'vpg-assets/css/vpg-admin.css', array(), WP_VPG_VERSION );
           wp_enqueue_style( 'vpg-admin-style' );
    }
    /**
     * Function to add Script at admin side
     * 
     * @package Video player gallery
     * @since 1.0.0
*/
add_action( 'admin_enqueue_scripts', 'wp_vpg_admin_script');
function wp_vpg_admin_script( $hook ) {
        // Registring and enqueing admin css
        wp_register_script( 'vpg-admin-script', WP_VPG_URL.'vpg-assets/js/vpg-admin.js', array('jquery'), WP_VPG_VERSION );
        wp_enqueue_script( 'vpg-admin-script' );
}
/* Function to get shortcode design
 * 
 * @package video player gallery
 * @since 1.0
 */
function vpg_templates() {
    $design_arr = array(
        'template-1'    => __('template-1', 'vpg-video-player'),
        'template-2'    => __('template-2', 'vpg-video-player'),
        'template-3'    => __('template-3', 'vpg-video-player'),
        'template-4'    => __('template-4', 'vpg-video-player'),
        'template-5'    => __('template-5', 'vpg-video-player'),
        'template-6'    => __('template-6', 'vpg-video-player'),
        );  
    return apply_filters('vpg_templates', $design_arr );
}
/* Function to get shortcode true false 
 * 
 * @package video player gallery
 * @since 1.0
 */
function sg_true_false() {
    $truefalse_arr = array(
        'true'    => __('True', 'vpg-video-player'),
        'false'    => __('False', 'vpg-video-player'),
       
        );  
    return apply_filters('sg_true_false', $truefalse_arr );
} 
/* Function to get shortcode Cell
 * 
 * @package video player gallery
 * @since 1.0
 */
function vpg_cell_arr() {
    $cell_arr = array(
        '1'    => __('1', 'vpg-video-player'),
        '2'    => __('2', 'vpg-video-player'),
        '3'    => __('3', 'vpg-video-player'),
        '4'    => __('4', 'vpg-video-player'),
        );  
    return apply_filters('sg_true_false', $cell_arr );
}
/* Function to get asc desc order fro shortcode
 * 
 * @package video player gallery
 * @since 1.0
 */
function vpg_asc_desc() {
    $vpg_asc_desc = array(
        'ASC'    => __('ASC', 'vpg-video-player'),
        'DESC'    => __('DESC', 'vpg-video-player'),
        );  
    return apply_filters('sg_asc_desc', $vpg_asc_desc );
}
/* Function to get order by fro shortcode
 * 
 * @package video player gallery
 * @since 1.0
 */
function vpg_orderby() {
    $vpg_orderby = array(
        'ID'    => __('ID', 'vpg-video-player'),
        'author'    => __('author', 'vpg-video-player'),
        'title'    => __('title', 'vpg-video-player'),
        'name'    => __('name', 'vpg-video-player'),
        'rand'    => __('rand', 'vpg-video-player'),
        'date'    => __('date', 'vpg-video-player'),
        );  
    return apply_filters('vpg_orderby', $vpg_orderby);
}
/**
 * Function to add array after specific key
 * 
 * @package video player gallery Pro
 * @since 1.0.0
 */
function vpg_add_array(&$array, $value, $index, $from_last = false) {
    if( is_array($array) && is_array($value) ) {
        if( $from_last ) {
            $total_count    = count($array);
            $index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
        }
        $split_arr  = array_splice($array, max(0, $index));
        $array      = array_merge( $array, $value, $split_arr);
    }
    return $array;
}
/**
 * Function to get grid column based on grid
 * 
 * @package video player gallery 
 * @since 1.0.0
 */
function vpg_grid_cell( $grid = '' ) {
    if($grid == '2') {
        $video_grid = '6';
    } else if($grid == '3') {
        $video_grid = '4';
    } else if($grid == '4') {
        $video_grid = '3';
    } else if ($grid == '1') {
        $video_grid = '12';
    } else {
        $video_grid = '12';
    }
    return $video_grid;
}
function vpg_get_excerpt($count){
    global $post;
    $permalink = get_permalink($post->ID);
    $excerpt = get_the_content();
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = $excerpt.'...,';
    return $excerpt;
}
/**
 * Escape Tags & Slashes
 *
 * manage plugin escapping the slashes and tags for input type
 *
 * @package video player gallery
 * @since 1.0
 */
function wp_vpg_esc_attr($data) {
    return esc_attr( stripslashes($data) );
}
/**
 * Clean input variables using sanitize_text_field  arrays are cleaned input recursively.
 * and non-scalar values are ignored automatically.
 * 
 * @package video player gallery
 * @since 1.0
 */
function wp_vpg_clean( $var ) {
    if ( is_array( $var ) ) {
        return array_map( 'wp_vpg_clean', $var );
    } else {
        $data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
        return wp_unslash($data);
    }
}
/**
 * make Sanitize URL.
 * 
 * @package video player gallery
 * @since 1.0
 */
function wp_vpg_clean_url( $url ) {
    return esc_url_raw( trim($url) );
}
/**
 * Sanitize Multiple HTML class
 * 
 * @package video player gallery
 * @since 1.0
 */
function vpg_sanitize_html_classes($classes, $sepr = " ") {
    $return = "";
    if( !is_array($classes) ) {
        $classes = explode($sepr, $classes);
    }
    if( !empty($classes) ) {
        foreach($classes as $class){
            $return .= sanitize_html_class($class) . " ";
        }
        $return = trim( $return );
    }
    return $return;
}