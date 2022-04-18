<?php
namespace ElaineRestaurant\Shortcodes\WorkingHours;

use ElaineRestaurant\Lib\ShortcodeInterface;

class WorkingHours implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'edgtf_working_hours';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Working Hours', 'elaine-restaurant'),
			'base'                      => $this->base,
			'category'                  => esc_html__('by ELAINE RESTAURANT', 'elaine-restaurant'),
			'icon'                      => 'icon-wpb-working-hours extended-custom-restaurant-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Title', 'elaine-restaurant'),
					'param_name'  => 'title',
					'admin_label' => true,
					'value'       => '',
					'save_always' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Title Accent Word', 'elaine-restaurant'),
					'param_name'  => 'title_accent_word',
					'admin_label' => true,
					'value'       => '',
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Enable Frame', 'elaine-restaurant'),
					'param_name'  => 'enable_frame',
					'description' => esc_html__('Enabling this option will display dark frame around working hours', 'elaine-restaurant'),
					'admin_label' => true,
					'value'       => array(
						''    => '',
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'save_always' => true
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__('Background Image', 'elaine-restaurant'),
					'param_name'  => 'bg_image',
					'admin_label' => true,
					'value'       => array(
						''    => '',
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'save_always' => true,
					'dependency'  => array('element' => 'enable_frame', 'value' => 'yes')
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'title'             => '',
			'title_accent_word' => '',
			'enable_frame'      => '',
			'bg_image'          => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		$params['working_hours']  = $this->getWorkingHours();
		$params['holder_classes'] = $this->getHolderClasses($params);
		$params['holder_styles']  = $this->getHolderStyles($params);

		return elaine_restaurant_get_template_part('modules/shortcodes/working-hours/templates/working-hours-template', '', $params, true);
	}

	private function getWorkingHours() {
		$workingHours = array();

		if(elaine_restaurant_theme_installed()) {
			//monday
			if(elaine_edge_options()->getOptionValue('wh_monday_from') !== '') {
				$workingHours['monday']['label'] = esc_html__('Monday', 'elaine-restaurant');
				$workingHours['monday']['from']  = elaine_edge_options()->getOptionValue('wh_monday_from');
			}

			if(elaine_edge_options()->getOptionValue('wh_monday_to') !== '') {
				$workingHours['monday']['to'] = elaine_edge_options()->getOptionValue('wh_monday_to');
			}

			//tuesday
			if(elaine_edge_options()->getOptionValue('wh_tuesday_from') !== '') {
				$workingHours['tuesday']['label'] = esc_html__('Tuesday', 'elaine-restaurant');
				$workingHours['tuesday']['from']  = elaine_edge_options()->getOptionValue('wh_tuesday_from');
			}

			if(elaine_edge_options()->getOptionValue('wh_tuesday_to') !== '') {
				$workingHours['tuesday']['to'] = elaine_edge_options()->getOptionValue('wh_tuesday_to');
			}

			//wednesday
			if(elaine_edge_options()->getOptionValue('wh_wednesday_from') !== '') {
				$workingHours['wednesday']['label'] = esc_html__('Wednesday', 'elaine-restaurant');
				$workingHours['wednesday']['from']  = elaine_edge_options()->getOptionValue('wh_wednesday_from');
			}

			if(elaine_edge_options()->getOptionValue('wh_wednesday_to') !== '') {
				$workingHours['wednesday']['to'] = elaine_edge_options()->getOptionValue('wh_wednesday_to');
			}

			//thursday
			if(elaine_edge_options()->getOptionValue('wh_thursday_from') !== '') {
				$workingHours['thursday']['label'] = esc_html__('Thursday', 'elaine-restaurant');
				$workingHours['thursday']['from']  = elaine_edge_options()->getOptionValue('wh_thursday_from');
			}

			if(elaine_edge_options()->getOptionValue('wh_thursday_to') !== '') {
				$workingHours['thursday']['to'] = elaine_edge_options()->getOptionValue('wh_thursday_to');
			}

			//friday
			if(elaine_edge_options()->getOptionValue('wh_friday_from') !== '') {
				$workingHours['friday']['label'] = esc_html__('Friday', 'elaine-restaurant');
				$workingHours['friday']['from']  = elaine_edge_options()->getOptionValue('wh_friday_from');
			}

			if(elaine_edge_options()->getOptionValue('wh_friday_to') !== '') {
				$workingHours['friday']['to'] = elaine_edge_options()->getOptionValue('wh_friday_to');
			}

			//saturday
			if(elaine_edge_options()->getOptionValue('wh_saturday_from') !== '') {
				$workingHours['saturday']['label'] = esc_html__('Saturday', 'elaine-restaurant');
				$workingHours['saturday']['from']  = elaine_edge_options()->getOptionValue('wh_saturday_from');
			}

			if(elaine_edge_options()->getOptionValue('wh_saturday_to') !== '') {
				$workingHours['saturday']['to'] = elaine_edge_options()->getOptionValue('wh_saturday_to');
			}

			//sunday
			if(elaine_edge_options()->getOptionValue('wh_sunday_from') !== '') {
				$workingHours['sunday']['label'] = esc_html__('Sunday', 'elaine-restaurant');
				$workingHours['sunday']['from']  = elaine_edge_options()->getOptionValue('wh_sunday_from');
			}

			if(elaine_edge_options()->getOptionValue('wh_sunday_to') !== '') {
				$workingHours['sunday']['to'] = elaine_edge_options()->getOptionValue('wh_sunday_to');
			}
		}

		return $workingHours;
	}

	private function getHolderClasses($params) {
		$classes = array('edgtf-working-hours-holder');

		if(isset($params['enable_frame']) && $params['enable_frame'] === 'yes') {
			$classes[] = 'edgtf-wh-with-frame';
		}

		if(isset($params['bg_image']) && $params['bg_image'] !== '') {
			$classes[] = 'edgtf-wh-with-bg-image';
		}

		return $classes;
	}

	private function getHolderStyles($params) {
		$styles = array();

		if($params['bg_image'] !== '') {
			$bg_url = wp_get_attachment_url($params['bg_image']);

			if(!empty($bg_url)) {
				$styles[] = 'background-image: url('.$bg_url.')';
			}
		}

		return $styles;
	}

}
