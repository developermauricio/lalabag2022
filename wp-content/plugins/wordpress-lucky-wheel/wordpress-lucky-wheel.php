<?php
/**
 * Plugin Name: WordPress Lucky Wheel Premium
 * Description: Collect customers emails by letting them play interesting Lucky wheel game to get interesting awards
 * Version: 1.0.4.3
 * Author: VillaTheme
 * Author URI: http://villatheme.com
 * Text Domain: wordpress-lucky-wheel
 * Domain Path: /languages
 * Copyright 2018-2020 VillaTheme.com. All rights reserved.
 * Tested up to: 5.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
define( 'VI_WORDPRESS_LUCKY_WHEEL_VERSION', '1.0.4.3' );
$init_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "wordpress-lucky-wheel" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "includes.php";
require_once $init_file;


if ( ! class_exists( 'WORDPRESS_LUCKY_WHEEL' ) ):
	class WORDPRESS_LUCKY_WHEEL {
		protected $settings;

		public function __construct() {
			$this->settings = new VI_WORDPRESS_LUCKY_WHEEL_DATA();
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
			add_action( 'init', array( $this, 'create_custom_post_type' ) );
			add_filter( 'manage_wplwl_email_posts_columns', array( $this, 'add_column' ), 10, 1 );
			add_action( 'manage_wplwl_email_posts_custom_column', array( $this, 'add_column_data' ), 10, 2 );
			add_filter(
				'plugin_action_links_wordpress-lucky-wheel/wordpress-lucky-wheel.php', array(
					$this,
					'settings_link'
				)
			);

		}

		public function settings_link( $links ) {
			$settings_link = '<a href="admin.php?page=wordpress-lucky-wheel" title="' . __( 'Settings', 'wordpress-lucky-wheel' ) . '">' . __( 'Settings', 'wordpress-lucky-wheel' ) . '</a>';
			array_unshift( $links, $settings_link );

			return $links;
		}

		public function create_custom_post_type() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			if ( post_type_exists( 'wplwl_email' ) ) {
				return;
			}
			$args = array(
				'labels'              => array(
					'name'               => _x( 'Lucky Wheel Email', 'wordpress-lucky-wheel' ),
					'singular_name'      => _x( 'Email', 'wordpress-lucky-wheel' ),
					'menu_name'          => _x( 'Emails', 'Admin menu', 'wordpress-lucky-wheel' ),
					'name_admin_bar'     => _x( 'Emails', 'Add new on Admin bar', 'wordpress-lucky-wheel' ),
					'view_item'          => __( 'View Email', 'wordpress-lucky-wheel' ),
					'all_items'          => __( 'Email Subscribe', 'wordpress-lucky-wheel' ),
					'search_items'       => __( 'Search Email', 'wordpress-lucky-wheel' ),
					'parent_item_colon'  => __( 'Parent Email:', 'wordpress-lucky-wheel' ),
					'not_found'          => __( 'No Email found.', 'wordpress-lucky-wheel' ),
					'not_found_in_trash' => __( 'No Email found in Trash.', 'wordpress-lucky-wheel' )
				),
				'description'         => __( 'WordPress lucky wheel emails.', 'wordpress-lucky-wheel' ),
				'public'              => false,
				'show_ui'             => true,
				'capability_type'     => 'post',
				'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_menu'        => false,
				'hierarchical'        => false,
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array( 'title' ),
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
			);
			register_post_type( 'wplwl_email', $args );
		}

		public function add_column( $columns ) {
			$columns['customer_name'] = __( 'Customer name', 'wordpress-lucky-wheel' );
			$columns['mobile']        = __( 'Mobile', 'wordpress-lucky-wheel' );
			$columns['spins']         = __( 'Number of spins', 'wordpress-lucky-wheel' );
			$columns['last_spin']     = __( 'Last spin', 'wordpress-lucky-wheel' );
			$columns['label']         = __( 'Labels', 'wordpress-lucky-wheel' );
			$columns['coupon']        = __( 'Coupons', 'wordpress-lucky-wheel' );

			return $columns;
		}

		public function add_column_data( $column, $post_id ) {
			switch ( $column ) {
				case 'customer_name':
					if ( get_post( $post_id )->post_content ) {
						echo get_post( $post_id )->post_content;
					}
					break;
				case 'mobile':
					if ( get_post_meta( $post_id, 'wplwl_email_mobile', true ) ) {
						echo get_post_meta( $post_id, 'wplwl_email_mobile', true );
					}
					break;
				case 'spins':
					if ( get_post_meta( $post_id, 'wplwl_spin_times', true ) ) {
						echo get_post_meta( $post_id, 'wplwl_spin_times', true )['spin_num'];
					}
					break;
				case 'last_spin':
					if ( get_post_meta( $post_id, 'wplwl_spin_times', true ) ) {
						echo date( 'Y-m-d h:i:s', get_post_meta( $post_id, 'wplwl_spin_times', true )['last_spin'] );
					}
					break;

				case 'label':
					if ( get_post_meta( $post_id, 'wplwl_email_labels', true ) ) {
						$label = get_post_meta( $post_id, 'wplwl_email_labels', true );
						if ( sizeof( $label ) > 1 ) {
							for ( $i = sizeof( $label ) - 1; $i >= 0; $i -- ) {
								echo '<p>' . $label[ $i ] . '</p>';
							}
						} else {
							echo $label[0];
						}
					}
					break;
				case 'coupon':
					if ( get_post_meta( $post_id, 'wplwl_email_coupons', true ) ) {
						$coupon = get_post_meta( $post_id, 'wplwl_email_coupons', true );
						if ( sizeof( $coupon ) > 1 ) {
							for ( $i = sizeof( $coupon ) - 1; $i >= 0; $i -- ) {
								echo '<p>' . $coupon[ $i ] . '</p>';
							}
						} else {
							echo $coupon[0];
						}
					}
					break;
			}
		}

		function load_plugin_textdomain() {
			$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
			$locale = apply_filters( 'plugin_locale', $locale, 'wordpress-lucky-wheel' );
			load_textdomain( 'wordpress-lucky-wheel', WP_PLUGIN_DIR . "/wordpress-lucky-wheel/languages/wordpress-lucky-wheel-$locale.mo" );
			load_plugin_textdomain( 'wordpress-lucky-wheel', false, basename( dirname( __FILE__ ) ) . "/languages" );
			if ( class_exists( 'VillaTheme_Support_Pro' ) ) {
				new VillaTheme_Support_Pro(
					array(
						'support'   => 'https://villatheme.com/supports/forum/plugins/wordpress-lucky-wheel/',
						'docs'      => 'http://docs.villatheme.com/?item=wordpress-lucky-wheel',
						'review'    => 'https://codecanyon.net/downloads',
						'css'       => VI_WORDPRESS_LUCKY_WHEEL_CSS,
						'image'     => VI_WORDPRESS_LUCKY_WHEEL_IMAGES,
						'slug'      => 'wordpress-lucky-wheel',
						'menu_slug' => 'wordpress-lucky-wheel',
						'version'   => VI_WORDPRESS_LUCKY_WHEEL_VERSION,
					)
				);
			}
		}

	}
endif;

new WORDPRESS_LUCKY_WHEEL();
