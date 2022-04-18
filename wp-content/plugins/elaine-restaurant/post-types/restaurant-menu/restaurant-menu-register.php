<?php
namespace ElaineRestaurant\CPT\RestaurantMenu;

use ElaineRestaurant\Lib;

/**
 * Class RestaurantMenuRegister
 * @package ElaineRestaurant\CPT\RestaurantMenu
 */

class RestaurantMenuRegister implements Lib\PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;
	/**
	 * @var string
	 */
	private $taxBase;

	public function __construct() {
		$this->base    = 'restaurant-menu';
		$this->taxBase = 'restaurant-menu-category';
	}

	/**
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	public function register() {
		$this->registerPostType();
		$this->registerTax();
	}

	/**
	 * Regsiters custom post type with WordPress
	 */
	private function registerPostType() {

		$menuPosition = 5;
		$menuIcon     = 'dashicons-list-view';

		register_post_type($this->base,
			array(
				'labels'        => array(
					'name'          => esc_html__('Restaurant Menu', 'elaine-restaurant'),
					'menu_name'     => esc_html__('Restaurant Menu', 'elaine-restaurant'),
					'all_items'     => esc_html__('Restaurant Menu Items', 'elaine-restaurant'),
					'add_new'       => esc_html__('Add New Restaurant Menu Item', 'elaine-restaurant'),
					'singular_name' => esc_html__('Restaurant Menu Item', 'elaine-restaurant'),
					'add_item'      => esc_html__('New Restaurant Menu Item', 'elaine-restaurant'),
					'add_new_item'  => esc_html__('Add New Restaurant Menu Item', 'elaine-restaurant'),
					'edit_item'     => esc_html__('Edit Restaurant Menu Item', 'elaine-restaurant')
				),
				'public'        => false,
				'show_in_menu'  => true,
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'has_archive'   => false,
				'hierarchical'  => false,
				'supports'      => array('title', 'thumbnail', 'page-attributes'),
				'menu_icon'     => $menuIcon
			)
		);
	}

	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__('Restaurant Menu Category', 'elaine-restaurant'),
			'singular_name'     => esc_html__('Restaurant Menu Category', 'elaine-restaurant'),
			'search_items'      => esc_html__('Search Restaurant Menu Categories', 'elaine-restaurant'),
			'all_items'         => esc_html__('All Restaurant Menu Categories', 'elaine-restaurant'),
			'parent_item'       => esc_html__('Parent Restaurant Menu Category', 'elaine-restaurant'),
			'parent_item_colon' => esc_html__('Parent Restaurant Menu Category:', 'elaine-restaurant'),
			'edit_item'         => esc_html__('Edit Restaurant Menu Category', 'elaine-restaurant'),
			'update_item'       => esc_html__('Update Restaurant Menu Category', 'elaine-restaurant'),
			'add_new_item'      => esc_html__('Add New Restaurant Menu Category', 'elaine-restaurant'),
			'new_item_name'     => esc_html__('New Restaurant Menu Category Name', 'elaine-restaurant'),
			'menu_name'         => esc_html__('Restaurant Menu Categories', 'elaine-restaurant'),
		);

		register_taxonomy($this->taxBase, array($this->base), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'show_admin_column' => true,
		));
	}

}