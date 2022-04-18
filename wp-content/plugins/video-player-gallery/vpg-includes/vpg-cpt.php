<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Function for Plugin create custom post type
 * 
 * @package video player gallery
 * @since 1.1
 */
function vpg_post_types() {
	$vpg_labels =  apply_filters( 'simple_vpg_labels', array(
		'name'                => 'Video Player',
		'singular_name'       => 'Video Player',
		'add_new'             => __('Add New', 'vpg-video-player'),
		'add_new_item'        => __('Add New Video', 'vpg-video-player'),
		'edit_item'           => __('Edit Video', 'vpg-video-player'),
		'new_item'            => __('New Video', 'vpg-video-player'),
		'all_items'           => __('All Videos', 'vpg-video-player'),
		'view_item'           => __('View Video Player', 'vpg-video-player'),
		'search_items'        => __('Search Video Player', 'vpg-video-player'),
		'not_found'           => __('No Videos Gallery found', 'vpg-video-player'),
		'not_found_in_trash'  => __('No Videos Gallery found in Trash', 'vpg-video-player'),
		'parent_item_colon'   => '',
		'menu_name'           => __('Video Player', 'vpg-video-player'),
		'exclude_from_search' => true
	) );
	$vpg_args = array(
		'labels' 			=> $vpg_labels,
		'public' 			=> false,
		'publicly_queryable'=> false,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'query_var' 		=> false,
		'capability_type' 	=> 'post',
		'has_archive' 		=> false,
		'menu_icon'   		=> 'dashicons-editor-video',
		'hierarchical' 		=> false,
		'supports' => array('title','thumbnail','editor')
	);
	register_post_type( WP_VPG_POST_TYPE, apply_filters( 'vpg_post_type_args', $vpg_args ) );
}
add_action('init', 'vpg_post_types');
function vpg_taxonomies() {
	$labels = array(
		'name'              => _x( 'Category', 'vpg-video-player' ),
		'singular_name'     => _x( 'Category', 'vpg-video-player' ),
		'search_items'      => __( 'Search Category', 'vpg-video-player' ),
		'all_items'         => __( 'All Category', 'vpg-video-player' ),
		'parent_item'       => __( 'Parent Category', 'vpg-video-player' ),
		'parent_item_colon' => __( 'Parent Category:', 'vpg-video-player' ),
		'edit_item'         => __( 'Edit Category', 'vpg-video-player' ),
		'update_item'       => __( 'Update Category', 'vpg-video-player' ),
		'add_new_item'      => __( 'Add New Category', 'vpg-video-player' ),
		'new_item_name'     => __( 'New Category Name', 'vpg-video-player' ),
		'menu_name'         => __( 'Video Category', 'vpg-video-player' ),
	);
	$args = array(
		'labels'            => $labels,
		'public'            => false,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => false,
	);
	register_taxonomy( WP_VPG_CAT, array( WP_VPG_POST_TYPE ), $args );
}
/* Register Taxonomy */
add_action( 'init', 'vpg_taxonomies');